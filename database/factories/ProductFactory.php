<?php

namespace Database\Factories;

use App\Models\{Category, Product, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'name' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'amount' => $this->faker->randomNumber(2),
            'current_quantity' => $this->faker->randomDigit,
            'minimum_quantity' => $this->faker->randomDigit,
        ];
    }
}
