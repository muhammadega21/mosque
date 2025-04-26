<?php

namespace Database\Factories;

use App\Models\UserData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserData>
 */
class UserDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = UserData::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nomor_hp' => $this->faker->numerify('08##########'),
            'alamat' => $this->faker->address(),
            'saldo' => $this->faker->numberBetween(100000, 1000000),
            'user_id' => null
        ];
    }
}
