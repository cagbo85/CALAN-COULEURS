<?php

namespace Database\Seeders;

use App\Models\Artiste;
use App\Models\Faq;
use App\Models\User;
use App\Models\Stand;
use App\Models\Partenaire;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'login' => 'superadmin',
            'email' => 'superadmin@test.com',
            'role' => 'super-admin',
            'actif' => true,
            'password' => bcrypt('superadmin_password'),
        ]);

        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'Test',
            'login' => 'admin',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'actif' => true,
            'password' => bcrypt('admin_password'),
        ]);

        User::factory()->create([
            'firstname' => 'Editor',
            'lastname' => 'Test',
            'login' => 'editor',
            'email' => 'editor@test.com',
            'role' => 'editor',
            'actif' => true,
            'password' => bcrypt('editor_password'),
        ]);

        Faq::factory()->count(5)->create();

        Stand::factory()->count(10)->create();

        Partenaire::factory()->count(10)->create();

        if (app()->environment(['testing', 'local'])) {
            Artiste::factory()->count(5)->create();

            Artiste::factory()->create([
                'name' => 'Test Artist Rock',
                'style' => 'Rock',
                'scene' => 'Extérieur',
                'actif' => true,
            ]);

            Artiste::factory()->create([
                'name' => 'Test Artist Electronic',
                'style' => 'Electronic',
                'scene' => 'Intérieur',
                'actif' => true,
            ]);
        }
    }
}
