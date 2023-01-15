<?php

namespace Performing\View\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Performing\View\Tests\FakeApp\Models\Post;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name()
        ];
    }
}
