<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    protected $model = Video::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'channel_id' => function() {
                return $this->factory(Video::class)->create()->id();
            },
            'title' => fake()->sentence(3),
            'description' => fake()->text(),
            'path' => fake()->word(),
            'percentage' => 100,
            'thumbnail' => fake()->imageUrl()
        ];
    }
}
