<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SmartIseed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iseed:smart {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère un seeder via iseed et le modernise (syntaxe [], variable $now, nettoyage des espaces, et nettoyage de DatabaseSeeder)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');
        $studlyTable = Str::studly($table);

        // Nom du fichier généré par iseed par défaut
        $iseedFileName = "{$studlyTable}TableSeeder.php";
        $iseedFilePath = database_path("seeders/{$iseedFileName}");

        // Nom du fichier cible personnalisé (ex: PartenaireSeeder.php)
        $customClassName = Str::studly(Str::singular($table)).'Seeder';
        $customFileName = "{$customClassName}.php";
        $customFilePath = database_path("seeders/{$customFileName}");

        $this->info('Étape 1 : Génération brute avec iseed...');

        // On force la génération via iseed
        Artisan::call("iseed {$table} --force");

        if (! File::exists($iseedFilePath)) {
            $this->error("Le fichier seeder n'a pas pu être trouvé à l'emplacement : {$iseedFilePath}");

            return 1;
        }

        $this->info('Étape 2 : Personnalisation et nettoyage du fichier...');
        $content = File::get($iseedFilePath);

        // 1. Ajout du Use de la Facade DB
        $content = str_replace(
            "use Illuminate\Database\Seeder;",
            "use Illuminate\Database\Seeder;\nuse Illuminate\Support\Facades\DB;",
            $content
        );

        // 2. Refonte globale du bloc de classe et suppression des sauts de ligne inutiles
        $patternHeader = '/class\s+'.$studlyTable.'TableSeeder\s+extends\s+Seeder\s*\{\s*\/\*\*([\s\S]*?)\*\/\s*public\s+function\s+run\(\)\s*\{\s*\\\DB::table\(\''.$table.'\'\)->delete\(\);\s*\\\DB::table\(\''.$table.'\'\)->insert\(array\s*\(\s*\d+\s*=>\s*array\s*\(/';

        $replacementHeader = "class {$customClassName} extends Seeder\n{\n".
            "    /**\n".
            "     * Auto generated seed file\n".
            "     *\n".
            "     * @return void\n".
            "     */\n".
            "    public function run()\n".
            "    {\n".
            "        DB::statement('SET FOREIGN_KEY_CHECKS=0;');\n".
            "        DB::table('{$table}')->truncate();\n".
            "        DB::statement('SET FOREIGN_KEY_CHECKS=1;');\n\n".
            "        \$now = date('Y-m-d H:i:s');\n\n".
            "        DB::table('{$table}')->insert([\n".
            '            [';

        $content = preg_replace($patternHeader, $replacementHeader, $content);

        // 3. Conversion globale de la vieille syntaxe array(...) restante en []
        $content = preg_replace('/array\s*\(/', '[', $content);
        $content = preg_replace('/\),/', '],', $content);

        // Ajustement pour la toute fin du bloc de fermeture de l'insert
        $content = str_replace('));', ']);', $content);

        // 4. Remplacement de tous les index numériques restants (ex: 1 => [ )
        $content = preg_replace('/\d+\s*=>\s*\[/', '[', $content);

        // 5. Remplacement dynamique des chaînes de dates par la variable $now
        $content = preg_replace('/\'\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\'/', '$now', $content);

        // 6. Nettoyage des fichiers : on supprime le fichier d'iseed et on écrit le nouveau
        File::delete($iseedFilePath);
        File::put($customFilePath, $content);

        // 7. Nettoyage de DatabaseSeeder.php
        $this->info('Étape 3 : Nettoyage de la pollution dans DatabaseSeeder.php...');
        $databaseSeederPath = database_path('seeders/DatabaseSeeder.php');

        if (File::exists($databaseSeederPath)) {
            $seederContent = File::get($databaseSeederPath);

            $badLinePattern = '/\s*\\$this->call\(\s*'.$studlyTable.'TableSeeder::class\s*\);.*/';
            $seederContent = preg_replace($badLinePattern, '', $seederContent);

            File::put($databaseSeederPath, $seederContent);
        }

        $this->info("Succès ! Ton seeder personnalisé est disponible ici : database/seeders/{$customFileName}");

        return 0;
    }
}
