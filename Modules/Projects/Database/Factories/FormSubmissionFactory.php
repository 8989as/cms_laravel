<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Projects\App\Models\FormSubmission;
use Modules\Projects\App\Models\Section;

class FormSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = FormSubmission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'section_id' => Section::factory(), // Creates a related section
            'form_data' => [
                'field1' => $this->faker->word,
                'field2' => $this->faker->sentence,
                'assets' => [
                    $this->faker->imageUrl(640, 480, 'business', true), // Mock asset URLs
                    $this->faker->imageUrl(640, 480, 'technology', true),
                ],
            ],
        ];
    }
}
