<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_regular_users_are_forbidden(): void
    {
        $user = User::create(['name' => 'U', 'email' => 'u@x.com', 'password' => 'secret-pass']);
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admins_can_open_the_dashboard(): void
    {
        $admin = User::create(['name' => 'A', 'email' => 'a@x.com', 'password' => 'secret-pass', 'is_admin' => true]);
        $this->actingAs($admin)->get('/admin')->assertOk();
    }
}
