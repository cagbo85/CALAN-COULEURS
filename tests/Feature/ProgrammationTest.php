<?php

namespace Tests\Feature;

use App\Models\Artiste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgrammationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer des artistes pour la programmation
        Artiste::factory()->count(3)->create([
            'actif' => true,
        ]);
    }

    public function test_homepage_displays_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_programmation_page_exists(): void
    {
        $response = $this->get('/programmation');

        $response->assertStatus(200);
    }

    public function test_festival_page_exists(): void
    {
        $response = $this->get('/notre-histoire');

        $response->assertStatus(200);
    }

    public function test_contact_page_exists(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }
}
