<?php

namespace Organon\Marketplace\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\Seller;

class SellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company;
        return [
            'name' => $name,
            'slug' => str_replace(' ', '-', $name),
            'description' => $this->faker->sentence,
            'address' => $this->faker->address,
            'payment_method' => 'Paypal: test@example.com',
        ];
    }
}
