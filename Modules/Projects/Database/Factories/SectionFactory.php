<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Projects\App\Models\Section;
use Modules\Projects\App\Models\Page;

class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->sentence(3),
                'ar' => 'اسم القسم',
            ],
            'description' => [
                'en' => $this->faker->paragraph,
                'ar' => 'وصف القسم',
            ],
            'key' => $this->faker->unique()->word,
            'page_id' => Page::factory(),
        ];
    }
}

