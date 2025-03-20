<?php

namespace Modules\Projects\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Projects\App\Models\Asset;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authenticateUser();
    }

    public function test_can_create_asset()
    {
        $project = \Modules\Projects\App\Models\Project::factory()->create();
        // Storage::fake('projects_assets');

        $file = UploadedFile::fake()->image('test_image.jpg');

        $data = [
            'image' => $file,
            'image_key' => 'test_asset',
        ];

        $response = $this->postJson(route('projects.assets.store', $project->id), $data);

        $response->assertStatus(201);

        // Generate the expected file path
        $expectedPath = 'projects_assets/' . $file->hashName();

        // Assert the file exists in the mocked storage
        Storage::disk('projects_assets')->assertExists($expectedPath);

        // Assert the database contains the asset record
        $this->assertDatabaseHas('assets', [
            'image_key' => $data['image_key'],
            'project_id' => $project->id,
            'image' => $expectedPath, // Ensure the saved path matches
        ]);

        // Assert the API response includes the full image URL
        $response->assertJsonFragment([
            'image' => Storage::disk('projects_assets')->url($expectedPath),
        ]);
    }

    public function test_can_update_asset()
    {
        $asset = Asset::factory()->create();
        Storage::fake('project_assets');

        $data = [
            'image' => UploadedFile::fake()->image('updated_image.jpg'),
            'image_key' => 'updated_asset',
        ];

        $response = $this->putJson(route('assets.update', $asset->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'image_key' => $data['image_key']]);
    }

    public function test_can_delete_asset()
    {
        $asset = Asset::factory()->create();

        $response = $this->deleteJson(route('assets.destroy', $asset->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('assets', ['id' => $asset->id]);
    }
}
