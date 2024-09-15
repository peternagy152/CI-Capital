<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MacroPublication>
 */
class MacroPublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "macro_id" => $this->faker->numberBetween(1,5) ,
            "name" => $this->faker->name ,
            "desc" => $this->faker->text ,
            "read_in" => rand(3,100) . " min" ,
            "report" => $this->faker->imageUrl  ,
        ];
    }
}
