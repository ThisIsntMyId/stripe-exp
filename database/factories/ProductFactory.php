<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'name' => $this->faker->catchPhrase(),
            'desc' => $this->faker->realText(200, 2),
            'quantity' => $this->faker->numberBetween(50,100),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'image' => 'https://picsum.photos/id/237/200/300?hash=' . Str::random(8),
        ];
    }
}
