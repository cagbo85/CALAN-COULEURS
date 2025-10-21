<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandsSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('stands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = date('Y-m-d H:i:s');

        DB::table('stands')->insert([
            [
                'name' => "Calan'Boutique",
                'description' => "Collection officielle Calan’Couleurs : t-shirts, sweats et accessoires exclusifs.",
                'photo' => "img/surplace/Calan'Boutique.webp",
                'type' => 'boutique',
                'instagram_url' => null,
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 1,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Atelier Solle',
                'description' => 'Créatrice de vêtements et accessoires en upcycling, uniques et stylés.',
                'photo' => 'img/surplace/Atelier Solle.webp',
                'type' => 'boutique',
                'instagram_url' => 'https://www.instagram.com/atelier_solle/',
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 2,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => "So'Galettes",
                'description' => "Je vous propose des galettes et crêpes garnies traditionnelles ou originales, pour un goût authentique de la Bretagne.",
                'photo' => "img/surplace/So'Galettes.webp",
                'type' => 'foodtruck',
                'instagram_url' => 'https://www.instagram.com/sogalettes/',
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 3,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sylvain Tacos et Burgers',
                'description' => 'Tacos garnis de viandes juteuses, burgers généreux, paninis grillés, une sélection de snacks et petites bouchées.',
                'photo' => 'img/surplace/Sylvain Tacos et Burgers.webp',
                'type' => 'foodtruck',
                'instagram_url' => 'https://www.instagram.com/sylvain_cart_/',
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 4,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ocelypse tattoo',
                'description' => "Propose des flashs exclusifs ou des tatouages éphémères pour tester l'expérience.",
                'photo' => 'img/surplace/Ocelypse tattoo.webp',
                'type' => 'tatouage',
                'instagram_url' => 'https://www.instagram.com/ocelypse_tattoo/',
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 5,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Les Dauphinelles Tattoo',
                'description' => 'Proposent des flashs exclusifs ou des tatouages éphémères pour tester l\'expérience.',
                'photo' => 'img/surplace/Les Dauphinelles Tattoo.webp',
                'type' => 'tatouage',
                'instagram_url' => 'https://www.instagram.com/lesdauphinelles_tattoo/',
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 6,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Stand Prévention & Sécurité',
                'description' => "Sensibiliser tout en s'amusant ! Infos, jeux et conseils pour faire la fête en toute sécurité, avec le sourire et les bons réflexes.",
                'photo' => 'img/surplace/Stand Prévention & Sécurité.webp',
                'type' => 'autre',
                'instagram_url' => null,
                'facebook_url' => null,
                'website_url' => null,
                'other_link' => null,
                'actif' => 1,
                'ordre' => 7,
                'year' => 2025,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
