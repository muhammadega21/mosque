<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuktiDonasi>
 */
class BuktiDonasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_donatur' => "Hamba Allah",
            'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'gambar' => 'donasi/LCpQGDl5JTXC55DwQM0W5onDWiZlGDbiuEyzPuCc.png',
        ];
    }
}
