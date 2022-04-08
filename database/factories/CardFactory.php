<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "sku_id" =>  $this->faker->numberBetween($min = 1000, $max = 9999),
            "first_edition" =>  $this->faker->numberBetween($min = 0, $max = 1),
            'serial_code' => $this->faker->numberBetween($min = 10000000, $max = 99999999),
            'category_id' => Category::inRandomOrder()->first()->id,
            'atk' => $this->faker->numberBetween($min = 0, $max = 999),
            'def' => $this->faker->numberBetween($min = 0, $max = 999),
            'qty_star' => $this->faker->numberBetween($min = 0, $max = 12),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomDigit,
            'image' => $this->faker->imageUrl($width = 200, $height = 200),
            'card_creation_date' => $this->faker->date
        ];
    }
}
