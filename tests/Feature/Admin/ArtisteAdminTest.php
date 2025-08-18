<?php

namespace Tests\Feature\Admin;

use App\Models\Artiste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtisteAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'actif' => true
        ]);
    }

    public function test_admin_can_view_artistes_index()
    {
        Artiste::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/artistes');

        $response->assertStatus(200);
        $response->assertSee('Gestion des artistes');
    }

    public function test_admin_can_create_artiste()
    {
        $artisteData = [
            'name' => 'Nouvel Artiste Test',
            'style' => 'Rock Alternatif',
            'description' => 'Description de test',
            'begin_date' => '2025-09-12 20:00:00',
            'ending_date' => '2025-09-12 21:30:00',
            'scene' => 'Extérieur',
            'actif' => true
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/artistes', $artisteData);

        $response->assertRedirect();
        $this->assertDatabaseHas('artistes', [
            'name' => 'Nouvel Artiste Test'
        ]);
    }

    public function test_super_admin_can_access_admin_artistes()
    {
        /** @var User $superAdmin */
        $superAdmin = User::factory()->create([
            'role' => 'super-admin',
            'actif' => true
        ]);

        $response = $this->actingAs($superAdmin)
            ->get('/admin/artistes');

        $response->assertStatus(200);
    }

    public function test_editor_cannot_access_admin_artistes()
    {
        /** @var User $editor */
        $editor = User::factory()->create([
            'role' => 'editor',
            'actif' => true
        ]);

        $response = $this->actingAs($editor)
            ->get('/admin/artistes');

        $response->assertStatus(403);
    }

    public function test_inactive_user_cannot_access_admin()
    {
        /** @var User $inactiveAdmin */
        $inactiveAdmin = User::factory()->create([
            'role' => 'admin',
            'actif' => false
        ]);

        $response = $this->actingAs($inactiveAdmin)
            ->get('/admin/artistes');

        $response->assertStatus(403);
    }

    public function test_guest_redirected_to_login()
    {
        $response = $this->get('/admin/artistes');

        $response->assertRedirect('/login');
    }
}
