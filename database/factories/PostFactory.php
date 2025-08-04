<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;
use App\Enums\Status;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $Keyword = $this->faker->randomElement(['Coffee', 'Tea', 'Kamboocha', 'Covfevfe']);
        return [
            'title' => str_replace('.', '',$this->faker->realTextBetween(1,10)) . ' ' .$Keyword,
            'content' => $this->faker->realText(),
            'image_data' => file_get_contents('https://coffee.alexflipnote.dev/IMk-3G2_fk8_coffee.jpg'),
            //'image_path' => 'https://coffee.alexflipnote.dev/IMk-3G2_fk8_coffee.jpg',
            'published_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(Status::cases()),
        ];
    }
}

