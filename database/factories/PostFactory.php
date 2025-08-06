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
            'Coffee', 'Tea', 'Kombucha', 'Decaf', 'Cold Brew', 'Espresso',
            'Matcha', 'Green Tea', 'Americano', 'Macchiato', 'Flat White',
            'Cappuccino', 'Affogato', 'Nitro Brew', 'Mocha', 'Chai Latte',
            'Turmeric Latte', 'Bubble Tea', 'Herbal Infusion', 'Oolong Tea',
            'Vietnamese Coffee', 'Iced Latte', 'Black Tea', 'Cortado',
            'Pumpkin Spice', 'French Press', 'Percolator', 'Arabica', 'Robusta'
        ];

        protected static $titles = [
            'You won\'t believe the ',
            'Top 10 drink that will make ',
            'Doctors hate it, here\'s why the ',
            'Get the most energy from your ',
            'Did you know that the '
        ];

        protected static $phrases = [
            'boosts energy', 'improves focus', 'burns fat', 'reduces stress',
            'enhances digestion', 'fights inflammation', 'loaded with antioxidants',
            'perfect for cold mornings', 'works better than coffee', 'makes you glow',
            'barista-approved', 'grandma\'s recipe', 'millennial favorite',
            'endorsed by nutritionists', 'easy to prepare at home'
        ];

        protected static $images = [
            'https://coffee.alexflipnote.dev/q9lLxywp5cU_coffee.jpg',
            'https://coffee.alexflipnote.dev/IMk-3G2_fk8_coffee.jpg',
            'https://coffee.alexflipnote.dev/EZysxddfvsc_coffee.png',
            'https://coffee.alexflipnote.dev/wRtTrmkE02Q_coffee.jpg',
            'https://coffee.alexflipnote.dev/utcMXZNs6bA_coffee.jpg',
            'https://coffee.alexflipnote.dev/7B1hLK79TTk_coffee.png',
            'https://coffee.alexflipnote.dev/dv2yk01gWPI_coffee.jpg',
            'https://coffee.alexflipnote.dev/pxj2AAaSxvo_coffee.jpg'


        ];
        //https://coffee.alexflipnote.dev/random.json for more random coffee images

        protected static $index = 0;

    public function definition(): array
    {
        $keyword = self::$keywords[self::$index % count(self::$keywords)];
        $title = self::$titles[self::$index % count(self::$titles)];
        $phrases = self::$phrases[self::$index % count(self::$phrases)];
        $image = self::$images[self::$index % count(self::$images)];
        self::$index++;
        
        return [
            'title' => $title . ' ' . $keyword . ' '. $phrases . ' ' . $this->faker->realTextBetween(30,50),
            'content' => $title . ' ' . $this->faker->realTextBetween(200,600),
            'image_data' => file_get_contents($image),
            'published_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(Status::cases()),
        ];
    }
}

