<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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

        protected static $keywords = [
            'Coffee ', 
            'Tea ', 
            'Kamboocha ', 
            'decaf', 
            'Iced ', 
            'Irish Coffee ',
            'Pumkin Spice Latte', 
            'Latte'
        ];

        protected static $titles = [
            'You won\'t believe ',
            'Top 10 drink that will make ',
            'Doctors hate it, here\'s why ',
            'Get the most energy from your ',
            'Did you know that  '
        ];

        protected static $images = [
            'https://coffee.alexflipnote.dev/q9lLxywp5cU_coffee.jpg',
            'https://coffee.alexflipnote.dev/IMk-3G2_fk8_coffee.jpg',
            'https://coffee.alexflipnote.dev/EZysxddfvsc_coffee.png',
            'https://coffee.alexflipnote.dev/wRtTrmkE02Q_coffee.jpg',
            'https://coffee.alexflipnote.dev/utcMXZNs6bA_coffee.jpg'
        ];
        //https://coffee.alexflipnote.dev/random.json for more random coffee images

        protected static $index = 0;

    public function definition(): array
    {
        $keyword = self::$keywords[self::$index % count(self::$keywords)];
        $title = self::$titles[self::$index % count(self::$titles)];
        $image = self::$images[self::$index % count(self::$images)];
        self::$index++;
        
        return [
            'title' => $title . $keyword . ' ' . $this->faker->realTextBetween(30,50),
            'content' => $title . ' ' . $this->faker->realText(),
            'image_data' => file_get_contents($image),
            'published_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(Status::cases()),
        ];
    }
}

