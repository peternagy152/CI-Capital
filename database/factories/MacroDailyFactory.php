<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MacroDaily>
 */
class MacroDailyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->text ,
            "desc" => $this->faker->paragraph ,
            "source_id" => $this->faker->numberBetween(1,10) ,
            "macro_id" => $this->faker->numberBetween(1,5) ,
        ];
    }
}
