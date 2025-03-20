<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Projects\App\Models\Asset;
use Modules\Projects\App\Models\Project;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition()
    {
        return [
            'image' => 'test_image.png',
            'image_key' => $this->faker->unique()->word,
            'project_id' => Project::factory(),
        ];
    }
}
