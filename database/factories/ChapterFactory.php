<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $manga = Manga::with('chapters')->get()->random();

        return [
            'number' => $manga->chapters->first() ? ($manga->chapters->last()->number + 1) : 0,
            'title' => 'chapter-' . $this->faker->unique()->numberBetween(1000, 9999),
            'manga_id' => $manga->id,
        ];
    }
}
