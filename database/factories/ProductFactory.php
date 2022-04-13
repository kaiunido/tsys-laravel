<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'model' => $this->faker->shuffle($this->faker->regexify('[A-Z]{5}[0-9]{4}')),
      'isbn13' => $this->faker->isbn13(),
      'condition' => $this->faker->numberBetween(0, 1),
      'location' => $this->faker->regexify('[A-Z]{3}[0-9]{3}'),
      //'quantity' => $this->faker->randomNumber(2),
      'stock_status_id' => $this->faker->numberBetween(1, 3),
      'image' => $this->faker->imageUrl(800, 600, 'Products', true),
      'manufacturer_id' => 1,
      'shipping' => $this->faker->numberBetween(0, 1),
      //'price' => $this->faker->randomFloat(2, 0, 500),
      'date_available' => $this->faker->dateTimeBetween('-5 years', '+1 month'),
      'weight' => $this->faker->randomFloat(2, 0.1, 2),
      'weight_id' => $this->faker->numberBetween(1, 2),
      'length' => $this->faker->randomFloat(2, 0.5, 20),
      'width' => $this->faker->randomFloat(2, 0.5, 20),
      'height' => $this->faker->randomFloat(2, 0.5, 20),
      'length_id' => 1,
      'subtract' => $this->faker->numberBetween(0, 1),
      'minimum' => 1,
      'sort_order' => $this->faker->numberBetween(0, 100),
      'status' => $this->faker->numberBetween(0, 1),
      'viewed' => $this->faker->numberBetween(0, 1000),
    ];
  }
}
