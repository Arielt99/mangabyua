<?php

namespace Database\Factories;

use App\Models\Manga;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MangaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manga::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = 'manga-' . $this->faker->unique()->numberBetween(1000, 9999);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->realText(500),
            'isMature' => 0,
        ];
    }
}
