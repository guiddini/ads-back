<?php

namespace Database\Factories;

use App\Models\Space;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
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
            'reservable_type'=>'App\Models\Space',
            'reservable_id'=>Space::all()->random()->id,
            'start_date'=>$this->faker->date('Y-m-d'),
            'end_date'=>$this->faker->date('Y-m-d')
        ];
    }
}
