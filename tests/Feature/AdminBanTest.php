<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminBanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_ban_and_unban_user_and_banned_cannot_login()
    {
        // arrange
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        // act: admin bans user
        $this->actingAs($admin)
            ->post(route('admin.user.ban', $user->id))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'banned' => true,
        ]);

        // banned user cannot login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors();

        // unban
        $this->actingAs($admin)
            ->post(route('admin.user.unban', $user->id))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'banned' => false,
        ]);
    }
}
