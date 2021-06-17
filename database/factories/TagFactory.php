<?php

namespace Database\Factories;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = 'tag-' . $this->faker->unique()->numberBetween(1000, 9999);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'isMature' => $this->faker->boolean(),
        ];
    }
}
