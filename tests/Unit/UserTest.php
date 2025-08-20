<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_roles_flags_work_as_expected(): void
    {
        $editor = User::factory()->create();
        $admin = User::factory()->admin()->create();
        $super = User::factory()->superAdmin()->create();

        $this->assertTrue($editor->isEditor());
        $this->assertFalse($editor->isAdmin());
        $this->assertFalse($editor->isSuperAdmin());

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isSuperAdmin());
        $this->assertFalse($admin->isEditor());

        $this->assertTrue($super->isSuperAdmin());
        $this->assertFalse($super->isAdmin());
        $this->assertFalse($super->isEditor());
    }

    public function test_active_flags_work_as_expected(): void
    {
        $active = User::factory()->create();
        $inactive = User::factory()->inactive()->create();

        $this->assertTrue($active->isActive());
        $this->assertFalse($inactive->isActive());
    }

    public function test_super_admin_can_delete_others_but_not_self(): void
    {
        $super = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->create();
        $editor = User::factory()->create();

        $this->assertTrue($super->canDeleteUser($admin));
        $this->assertTrue($super->canDeleteUser($editor));
        $this->assertFalse($super->canDeleteUser($super));
    }

    public function test_non_super_admin_cannot_delete_users(): void
    {
        $admin = User::factory()->admin()->create();
        $editor = User::factory()->create();

        $target = User::factory()->create();

        $this->assertFalse($admin->canDeleteUser($target));
        $this->assertFalse($editor->canDeleteUser($target));
    }

    public function test_it_sends_custom_verify_email_notification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }
}
