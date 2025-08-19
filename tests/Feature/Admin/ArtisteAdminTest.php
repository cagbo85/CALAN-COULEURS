<?php

namespace Tests\Feature\Admin;

use App\Models\Artiste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtisteAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $editor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'login' => 'admin',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'actif' => true,
        ]);

        $this->editor = User::factory()->create([
            'firstname' => 'Editor',
            'lastname' => 'User',
            'login' => 'editor',
            'email' => 'editor@test.com',
            'role' => 'editor',
            'actif' => true,
        ]);
    }

    public function test_admin_middleware_works(): void
    {
        // Test simple que l'admin peut accéder au dashboard
        $response = $this->actingAs($this->admin)
            ->get('/dashboard');

        $response->assertStatus(200);
    }
    public function test_editor_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->editor)
            ->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_artiste_factory_works(): void
    {
        $artiste = Artiste::factory()->create([
            'name' => 'Test Artist',
            'style' => 'Rock',
        ]);

        $this->assertDatabaseHas('artistes', [
            'name' => 'Test Artist',
            'style' => 'Rock',
        ]);
    }
}
