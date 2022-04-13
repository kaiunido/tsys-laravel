<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDescription>
 */
class ProductDescriptionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'product_id' => ProductFactory::class,
      'language_id' => 1,
      'name' => $this->faker->sentence(5),
      'description' => $this->faker->paragraphs(3, true),
    ];
  }
}
