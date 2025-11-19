<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Kos;
use App\Models\Kamar;
use App\Models\RentalRequest;

class UserBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_rental_request_for_specific_kamar()
    {
        $pemilik = User::factory()->create(['role' => 'pemilik']);
        $kos = Kos::factory()->create(['user_id' => $pemilik->id]);
        $kamar = Kamar::factory()->create(['kos_id' => $kos->id, 'status' => 'kosong']);

        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->post(route('user.rental_requests.store'), [
                'kos_id' => $kos->id,
                'kamar_id' => $kamar->id,
                'start_date' => now()->addDay()->toDateString(),
                'end_date' => now()->addDays(10)->toDateString(),
            ])
            ->assertRedirect(route('user.rental_requests.index'));

        $this->assertDatabaseHas('rental_requests', [
            'user_id' => $user->id,
            'kos_id' => $kos->id,
            'kamar_id' => $kamar->id,
            'status' => 'pending',
        ]);
    }

    public function test_pemilik_can_approve_rental_request_and_assign_kamar()
    {
        $pemilik = User::factory()->create(['role' => 'pemilik']);
        $kos = Kos::factory()->create(['user_id' => $pemilik->id]);
        $kamar = Kamar::factory()->create(['kos_id' => $kos->id, 'status' => 'kosong']);

        $user = User::factory()->create(['role' => 'user']);

        $rental = RentalRequest::create([
            'user_id' => $user->id,
            'kos_id' => $kos->id,
            'kamar_id' => $kamar->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'status' => 'pending',
        ]);

        $this->actingAs($pemilik)
            ->post(route('pemilik.rental_requests.approve', $rental), [
                'kamar_id' => $kamar->id,
            ])
            ->assertRedirect(route('pemilik.rental_requests.index'));

        $this->assertDatabaseHas('rental_requests', [
            'id' => $rental->id,
            'status' => 'approved',
            'kamar_id' => $kamar->id,
        ]);

        $this->assertDatabaseHas('kamars', [
            'id' => $kamar->id,
            'status' => 'terisi',
        ]);

        $this->assertDatabaseHas('penghunis', [
            'user_id' => $user->id,
            'kamar_id' => $kamar->id,
            'status' => 'aktif',
        ]);
    }
}
