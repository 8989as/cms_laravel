<?php

namespace Modules\Projects\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Projects\App\Models\Page;
use Modules\Projects\App\Models\Project;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->authenticateUser(); // Call the authentication method
    }

    public function test_can_create_page()
    {
        $project = Project::factory()->create();

        $data = [
            'name' => ['en' => 'Test Page', 'ar' => 'صفحة تجريبية'],
            'description' => ['en' => 'Test page description', 'ar' => 'وصف صفحة تجريبية'],
            'project_id' => $project->id,
        ];

        $response = $this->postJson(route('pages.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => $data['name']]);
        $this->assertDatabaseHas('pages', ['project_id' => $project->id]);
    }

    public function test_can_read_page()
    {
        $page = Page::factory()->create();

        $response = $this->getJson(route('pages.show', $page->id));

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $page->id]);
    }

    public function test_can_update_page()
    {
        $page = Page::factory()->create();

        $updatedData = [
            'name' => ['en' => 'Updated Page', 'ar' => 'صفحة محدثة'],
            'description' => ['en' => 'Updated description', 'ar' => 'وصف محدث'],
            'project_id' => $page->project_id,
        ];

        $response = $this->putJson(route('pages.update', $page->id), $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $updatedData['name']]);
        $this->assertDatabaseHas('pages', ['id' => $page->id, 'name->en' => 'Updated Page']);
    }

    public function test_can_delete_page()
    {
        $page = Page::factory()->create();

        $response = $this->deleteJson(route('pages.destroy', $page->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
