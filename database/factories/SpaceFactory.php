<?php

namespace Database\Factories;

use App\Models\Space;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Space>
 */
class SpaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>User::all()->random()->id,
            'name'=>$this->faker->sentence(),
            'desc'=>$this->faker->text(),
            'image'=>'image.jpg',
            'cat'=>rand(1,3),
            'price'=>rand(100,1000),
            'height'=>rand(1000,2000),
            'width'=>rand(500,1000),
            'location'=>$this->faker->sentence(),
            'available'=>$this->faker->boolean()
        ];
    }
}
