<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $quantity = $this->faker->randomNumber(2);
    $sold = $this->faker->numberBetween(0, $quantity);

    return [
      'nf_id' => null,
      'product_id' => ProductFactory::class,
      'quantity' => $quantity,
      'quantity_sold' => $sold,
      'has_stock' => $quantity === $sold ? 1 : 0,
      'price' => $this->faker->randomFloat(2, 0, 500),
    ];
  }
}
