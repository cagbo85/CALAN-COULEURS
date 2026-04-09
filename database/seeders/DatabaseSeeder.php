<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //
        if (app()->environment('testing', 'local')) {
            User::updateOrCreate(
                ['id' => 1],
                [
                    'firstname' => 'Test',
                    'lastname' => 'Admin',
                    'login' => 'admin',
                    'email' => 'testtest@gmail.com',
                    'role' => 'admin',
                ]
            );
        }

        $this->call([
            EditionSeeder::class,
            ArtisteSeeder::class,
            PerformanceSeeder::class,
            StandSeeder::class,
            PartenaireSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            FaqSeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            EditionStandsSeeder::class,
            EditionPartenairesSeeder::class,
        ]);
    }
}
