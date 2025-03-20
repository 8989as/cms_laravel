<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Projects\App\Models\Project::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'name' => ['en' => $this->faker->name],
            'url' => $this->faker->url,
            'key' => $this->faker->unique()->slug,
            'description' => ['en' => $this->faker->sentence],
            'icon' => $this->faker->imageUrl(),
            'pages_number' => $this->faker->numberBetween(1, 10),
        ];
    }
}

