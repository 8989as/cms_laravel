<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Projects\App\Models\Color;
use Modules\Projects\App\Models\Project;

class ColorFactory extends Factory
{
    protected $model = Color::class;

    public function definition()
    {
        return [
            'hex_code' => $this->faker->hexColor,
            'color_key' => $this->faker->unique()->word,
            'project_id' => Project::factory(),
        ];
    }
}
