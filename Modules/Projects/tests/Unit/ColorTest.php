<?php

namespace Modules\Projects\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Projects\App\Models\Color;
use Modules\Projects\App\Models\Project;
use Tests\TestCase;

class ColorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authenticateUser(); // Call the authentication method
    }
    
    public function test_can_create_color()
    {
        $project = Project::factory()->create();
        $data = [
            'hex_code' => '#FF5733',
            'color_key' => 'test_color',
        ];

        $response = $this->postJson(route('projects.colors.store', $project->id), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('colors', [
            'hex_code' => $data['hex_code'],
            'color_key' => $data['color_key'],
            'project_id' => $project->id,
        ]);
    }

    public function test_can_update_color()
    {
        $color = Color::factory()->create();

        $data = [
            'hex_code' => '#123456',
            'color_key' => 'updated_color',
        ];

        $response = $this->putJson(route('colors.update', $color->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('colors', [
            'id' => $color->id,
            'hex_code' => $data['hex_code'],
            'color_key' => $data['color_key'],
        ]);
    }

    public function test_can_delete_color()
    {
        $color = Color::factory()->create();

        $response = $this->deleteJson(route('colors.destroy', $color->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('colors', ['id' => $color->id]);
    }
}
