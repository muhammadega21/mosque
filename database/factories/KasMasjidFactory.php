<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KasMasjid>
 */
class KasMasjidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = $this->faker->randomElement(['kas masuk', 'kas keluar']);
        $jumlah = match ($jenis) {
            'kas masuk' => $this->faker->numberBetween(1, 100) * 2000,
            'kas keluar' => $this->faker->numberBetween(1, 100) * 1000,
        };

        $kategori_id = 1;
        if ($jenis === 'kas keluar') {
            $kategori_id = $this->faker->randomElement([2, 3, 4, 5, 6, 7]);
        }

        return [
            'user_id' => 1,
            'jenis_kas' => $jenis,
            'jumlah' => $jumlah,
            'keterangan' => $this->faker->sentence(),
            'status_validasi' => 'selesai',
            'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'kategori_id' => $kategori_id,
            'donasi_id' => $jenis === 'kas keluar' ? null : \App\Models\BuktiDonasi::factory(),
        ];
    }
}
