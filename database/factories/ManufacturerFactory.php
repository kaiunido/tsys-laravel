<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manufacturer>
 */
class ManufacturerFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name' => $this->faker->company(),
      'image' => $this->faker->imageUrl(300, 300, 'Manufactorer', true),
      'sort_order' => $this->faker->numberBetween(0, 100),
    ];
  }
}
