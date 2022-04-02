<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seo>
 */
class SeoFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $tags = '';

    for ($i = 0; $i <= random_int(1, 5); $i++) {
      $tags .= $this->faker->word() . ', ';
    }

    return [
      'language_id' => 1,
      'meta_title' => $this->faker->sentence(5),
      'meta_description' => $this->faker->sentence(10),
      'meta_tags' => $tags,
    ];
  }
}
