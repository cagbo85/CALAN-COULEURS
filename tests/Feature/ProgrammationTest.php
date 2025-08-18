<?php

namespace Tests\Feature;

use App\Models\Artiste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgrammationTest extends TestCase
{
    use RefreshDatabase;

    public function test_lineup_page_loads_successfully()
    {
        $response = $this->get('/lineup');

        $response->assertStatus(200);
        $response->assertSee('Programmation 2025');
        $response->assertSee('Tous les artistes');
    }

    public function test_lineup_displays_active_artistes()
    {
        // Créer des artistes actifs et inactifs
        $artisteActif = Artiste::factory()->create([
            'name' => 'Artiste Visible',
            'actif' => true
        ]);

        $artisteInactif = Artiste::factory()->create([
            'name' => 'Artiste Caché',
            'actif' => false
        ]);

        $response = $this->get('/lineup');

        $response->assertSee('Artiste Visible');
        $response->assertDontSee('Artiste Caché');
    }

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_contact_page_loads_successfully()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

    public function test_festival_page_loads_successfully()
    {
        $response = $this->get('/festival');

        $response->assertStatus(200);
    }
}
