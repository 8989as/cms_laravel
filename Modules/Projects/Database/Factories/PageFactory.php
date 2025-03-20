<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Projects\App\Models\Page;
use Modules\Projects\App\Models\Project;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->word,
                'ar' => 'اسم الصفحة',
            ],
            'description' => [
                'en' => $this->faker->sentence,
                'ar' => 'وصف الصفحة',
            ],
            'key' => $this->faker->unique()->word,
            'project_id' => Project::factory(),
        ];
    }
}

