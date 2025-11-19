<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kos;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRevenueTest extends TestCase
{
    use RefreshDatabase;

    public function test_revenue_report_aggregates_lunas_payments_per_owner()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pemilik = User::factory()->create(['role' => 'pemilik']);
        $penghuniUser = User::factory()->create(['role' => 'user']);

        $kos = Kos::create([
            'user_id' => $pemilik->id,
            'nama' => 'Kos A',
            'alamat' => 'Alamat A',
            'deskripsi' => 'Desc',
            'status' => 'approved',
        ]);

        $kamar = Kamar::create([
            'kos_id' => $kos->id,
            'nomor' => 'Kamar 1',
            'kelas' => 'ekonomi',
            'harga' => 1000000,
            'status' => 'terisi',
        ]);

        $penghuni = Penghuni::create([
            'user_id' => $penghuniUser->id,
            'kamar_id' => $kamar->id,
            'tanggal_masuk' => now()->toDateString(),
            'status' => 'aktif',
        ]);

        Pembayaran::create([
            'penghuni_id' => $penghuni->id,
            'jumlah' => 500000,
            'tanggal_bayar' => now()->subDays(2)->toDateString(),
            'metode' => 'cash',
            'status' => 'lunas',
        ]);

        Pembayaran::create([
            'penghuni_id' => $penghuni->id,
            'jumlah' => 250000,
            'tanggal_bayar' => now()->subDays(1)->toDateString(),
            'metode' => 'transfer',
            'status' => 'lunas',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.revenue'));
        $response->assertStatus(200);

        $rows = $response->viewData('rows');
        $this->assertNotEmpty($rows);
        $this->assertEquals(750000.00, (float)$rows[0]->total_revenue);
    }
}
