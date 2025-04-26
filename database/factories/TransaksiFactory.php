<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Transaksi::class;

    public function definition(): array
    {
        $jenis = $this->faker->randomElement(['masuk', 'keluar']);
        $jumlah = match ($jenis) {
            'masuk' => $this->faker->numberBetween(1, 100) * 2000,
            'keluar' => $this->faker->numberBetween(1, 100) * 1000,
        };

        return [
            'user_id' => $this->faker->numberBetween(1, 20),
            'jenis_transaksi' => $jenis,
            'jumlah' => $jumlah,
            'status_transaksi' => 'selesai',
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'kategori_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
