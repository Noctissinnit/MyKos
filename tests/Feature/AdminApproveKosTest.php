<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kos;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminApproveKosTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_and_reject_kos_application()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pemilik = User::factory()->create(['role' => 'pemilik']);

        $kos = Kos::create([
            'user_id' => $pemilik->id,
            'nama' => 'Kos Test',
            'alamat' => 'Jl. Tes',
            'deskripsi' => 'Deskripsi',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.kos.approve', $kos->id))
            ->assertRedirect();

        $this->assertDatabaseHas('kos', [
            'id' => $kos->id,
            'status' => 'approved',
        ]);

        // create another kos and reject
        $kos2 = Kos::create([
            'user_id' => $pemilik->id,
            'nama' => 'Kos Test 2',
            'alamat' => 'Jl. Tes 2',
            'deskripsi' => 'Desc2',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.kos.reject', $kos2->id))
            ->assertRedirect();

        $this->assertDatabaseHas('kos', [
            'id' => $kos2->id,
            'status' => 'rejected',
        ]);
    }
}
