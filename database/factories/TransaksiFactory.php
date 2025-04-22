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
        $jumlah = $this->faker->numberBetween(10000, 1000000);
        return [
            'user_id' => $this->faker->numberBetween(1, 3),
            'jenis_transaksi' => $jenis,
            'jumlah' => $jumlah,
            'status_transaksi' => 'selesai',
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'kategori_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
