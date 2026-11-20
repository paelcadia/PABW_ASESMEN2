<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Donasis\Models\Donasis;
use Modules\Pengajuan\Models\Pengajuan;
use Tests\TestCase;

class PengajuanSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_submit_a_complaint_with_an_eight_character_description(): void
    {
        $user = User::factory()->create();
        $Donasis = Donasis::create([
            'nama' => 'Gedung A',
            'lokasi' => 'Kampus',
            'kondisi' => 'baik',
        ]);

        $response = $this->actingAs($user)->postJson(route('Pengajuan.store'), [
            'Donasis_id' => $Donasis->id,
            'judul' => 'Kerusakan Toilet Perpustakaan',
            'deskripsi' => '321RDFSF',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.user_id', $user->id)
            ->assertJsonPath('data.Donasis_id', $Donasis->id)
            ->assertJsonPath('data.status', 'menunggu');

        $this->assertDatabaseHas('Pengajuans', [
            'user_id' => $user->id,
            'Donasis_id' => $Donasis->id,
            'deskripsi' => '321RDFSF',
            'status' => 'menunggu',
        ]);
    }

    public function test_invalid_complaint_is_not_inserted_and_returns_validation_errors(): void
    {
        $user = User::factory()->create();
        $Donasis = Donasis::create([
            'nama' => 'Gedung A',
            'lokasi' => 'Kampus',
            'kondisi' => 'baik',
        ]);

        $response = $this->actingAs($user)->postJson(route('Pengajuan.store'), [
            'Donasis_id' => $Donasis->id,
            'judul' => 'Kerusakan Toilet Perpustakaan',
            'deskripsi' => '1234',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('deskripsi');

        $this->assertSame(0, Pengajuan::count());
    }
}
