<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "company_id" => $this->faker->numberBetween(1,20) ,
            "name" => $this->faker->name ,
            "desc" => $this->faker->text ,
            "read_in" => rand(3,100) . " min" ,
            "report" => $this->faker->imageUrl  ,
        ];
    }
}
