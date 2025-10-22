<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('faqs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = date('Y-m-d H:i:s');

        DB::table('faqs')->insert([
            [
                'question'   => "Où et quand se déroule le festival ?",
                'answer'     => "Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de vibes 🔥",
                'actif'      => 1,
                'ordre'      => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => "À quelle heure ouvrent les portes ?",
                'answer'     => "On t’accueille dès 19h vendredi et 13h samedi. Viens tôt, repars tard 😉",
                'actif'      => 1,
                'ordre'      => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => "Quels sont les styles de musique proposés ?",
                'answer'     => "Électro, rock, rap, dub… On mélange les styles pour faire kiffer tout le monde 🎶",
                'actif'      => 1,
                'ordre'      => 3,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => "Y a-t-il une billetterie sur place ?",
                'answer'     => "Oui, mais sans garantie 😬. Le mieux, c’est de choper ta place en ligne avant que ça parte !",
                'actif'      => 1,
                'ordre'      => 4,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => "Y aura-t-il des espaces de restauration ?",
                'answer'     => "Évidemment ! Foodtrucks, buvette, de quoi manger, boire et recharger les batteries 🍔🍻",
                'actif'      => 1,
                'ordre'      => 5,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => "Pourra-t-on dormir sur place ?",
                'answer'     => "Oui carrément ! Le camping est prévu, ramène juste ton matériel et ta bonne humeur 🌙🎪🔥",
                'actif'      => 1,
                'ordre'      => 6,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // 7ème inactif
            [
                'question'   => "Question de test (inactif)",
                'answer'     => "Entrée de test — cette FAQ est inactive et ne s'affichera pas.",
                'actif'      => 0,
                'ordre'      => 7,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
