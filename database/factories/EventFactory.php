<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->text,
            "desc" => $this->faker->paragraph,
            "cat" => $this->faker->randomElement([
                "Events",
                "Quick Insights",
                "Online",
                "Reports"
            ]),
            "published_at" => $this->faker->date,
            "webinar_link" => $this->faker->url,

        ];
    }
}
