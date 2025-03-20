<?php

namespace Modules\Projects\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Projects\App\Models\Project;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Fake the storage for testing file uploads
        Storage::fake('public');

        // Create and authenticate a user
        $this->user = \Modules\ACL\App\Models\User::factory()->create();
        $this->actingAs($this->user, 'sanctum'); // Use Sanctum or the appropriate guard
    }

    /** @test */
    public function it_can_create_a_project()
    {
          // Simulate an authenticated user
        $this->actingAs(\Modules\ACL\App\Models\User::factory()->create(), 'sanctum'); // Use the correct guard

        $data = [
            'name' => [
                'en' => 'Test Project',
                'ar' => 'مشروع تجريبي',
            ],
            'description' => [
                'en' => 'This is a test project.',
                'ar' => 'هذا مشروع تجريبي.',
            ],
            'url' => 'https://example.com',
            'key' => 'test_project',
            'icon' => UploadedFile::fake()->image('icon.jpg'),
        ];

        $response = $this->postJson(route('projects.store'), $data);

        $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Project created successfully',
        ]);

        // Assert database has the translated fields
        $this->assertDatabaseHas('projects', [
            'key' => 'test_project',
            'url' => 'https://example.com',
        ]);

        $project = Project::first();

        // Assert that translations are stored correctly
        $this->assertEquals('Test Project', $project->getTranslation('name', 'en'));
        $this->assertEquals('مشروع تجريبي', $project->getTranslation('name', 'ar'));
        $this->assertEquals('This is a test project.', $project->getTranslation('description', 'en'));
        $this->assertEquals('هذا مشروع تجريبي.', $project->getTranslation('description', 'ar'));
        
         // Get the full URL of the uploaded icon from the response
        $fullIconUrl = $response->json('data.icon'); // e.g., http://dashboard-content-managment.test/storage/projects_icons/filename.jpg
       
        // Extract the relative path from the full URL
        $relativePath = str_replace(url(Storage::url('')).'/', '', $fullIconUrl);
       
        // Assert that the file exists in the fake storage
        Storage::disk('public')->assertExists($relativePath);
    }

    /** @test */
    public function it_can_get_paginated_projects()
    {
        Project::factory()->count(5)->create();

        $response = $this->getJson(route('projects.index'));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Projects retrieved successfully',
                 ]);
        
        $this->assertCount(5, $response->json('data')); // Check if pagination contains 5 projects
    }

    /** @test */
    public function it_can_get_a_single_project()
    {
        $project = Project::factory()->create();

        $response = $this->getJson(route('projects.show', $project->id));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Project retrieved successfully',
                     'data' => [
                         'id' => $project->id,
                         'name' => $project->name,
                     ],
                 ]);
    }

    /** @test */
    public function it_can_update_a_project()
    {
        $project = Project::factory()->create([
            'name' => [
                'en' => 'Old Project Name',
                'ar' => 'الاسم القديم',
            ],
            'description' => [
                'en' => 'Old description.',
                'ar' => 'الوصف القديم.',
            ],
            'icon' => 'projects_icons/old_icon.jpg',
        ]);
    
        $data = [
            '_method' => 'PUT', // Simulate a PUT request
            'name' => [
                'en' => 'Updated Project Name',
                'ar' => 'الاسم المحدث',
            ],
            'description' => [
                'en' => 'Updated description.',
                'ar' => 'الوصف المحدث.',
            ],
            'url' => 'https://updated-example.com',
            'key' => $project->key, // Use the same key to avoid uniqueness validation issues
            'icon' => UploadedFile::fake()->image('new_icon.jpg'),
        ];

        // Send POST request with `_method=PUT`
        $response = $this->post(route('projects.update', $project->id), $data);


        $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Project updated successfully',
        ]);

        // Assert database has the updated project data
        $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'url' => 'https://updated-example.com',
        ]);

        // Validate that translations are updated correctly
        $project->refresh();
        $this->assertEquals('Updated Project Name', $project->getTranslation('name', 'en'));
        $this->assertEquals('الاسم المحدث', $project->getTranslation('name', 'ar'));
        $this->assertEquals('Updated description.', $project->getTranslation('description', 'en'));
        $this->assertEquals('الوصف المحدث.', $project->getTranslation('description', 'ar'));

        // Get the new icon path from the response
        $newIconPath = str_replace(url(Storage::url('')).'/', '', $response->json('data.icon'));

        // Assert that the old icon was deleted from storage
        Storage::disk('public')->assertMissing('projects_icons/old_icon.jpg');

        // Assert that the new icon exists in storage
        Storage::disk('public')->assertExists($newIconPath);
    }

    /** @test */
    public function it_can_delete_a_project()
    {
        $project = Project::factory()->create([
            'icon' => 'projects_icons/icon_to_delete.jpg',
        ]);

        $response = $this->deleteJson(route('projects.destroy', $project->id));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Project deleted successfully',
                 ]);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);

        // Assert the icon is deleted
        Storage::disk('public')->assertMissing('projects_icons/icon_to_delete.jpg');
    }

    /** @test */
    public function it_returns_404_for_nonexistent_project()
    {
        $response = $this->getJson(route('projects.show', 999));

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Project not found',
                 ]);
    }
}