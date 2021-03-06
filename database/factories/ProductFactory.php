<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;
    private $randomPrices = [
        30,
        40,
        50,
        60,
        70
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Random index to choose from 'randomPrices'
        $randomIndex = array_rand($this->randomPrices);

        return [
            "name" => $this->faker->bothify('?###??##'),
            "price" => $this->randomPrices[$randomIndex]
        ];
    }

    public function configure()
    {
        // Create random special price for product
        return $this->afterCreating(function (Product $product) {
            foreach (range(2, rand(2, 4)) as $i) {
                $specialPriceForOneItem = $product->price - ($product->price * ($i / 10));

                $product->specialPrices()->create([
                    "quantity" => $i,
                    "price" => $specialPriceForOneItem * $i
                ]);
            }
        });
    }
}
