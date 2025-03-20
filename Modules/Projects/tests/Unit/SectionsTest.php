<?php

namespace Modules\Projects\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Projects\App\Models\Page;
use Modules\Projects\App\Models\Section;
use Tests\TestCase;

class SectionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authenticateUser();
    }

    public function test_can_create_section()
    {
        $page = Page::factory()->create();

        $data = [
            'name' => ['en' => 'Test Section', 'ar' => 'قسم تجريبي'],
            'description' => ['en' => 'Test section description', 'ar' => 'وصف قسم تجريبي'],
            'page_id' => $page->id,
        ];

        $response = $this->postJson(route('sections.store', ['page_id' => $page->id]), $data);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => $data['name']]);
        $this->assertDatabaseHas('sections', ['page_id' => $page->id]);
    }

    public function test_can_read_sections()
    {
        $page = Page::factory()->create();
        $sections = Section::factory()->count(2)->create(['page_id' => $page->id]);

        $response = $this->getJson(route('sections.index', ['page_id' => $page->id]));

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_can_update_section()
    {
        $section = Section::factory()->create();

        $updatedData = [
            'name' => ['en' => 'Updated Section', 'ar' => 'قسم محدث'],
            'description' => ['en' => 'Updated description', 'ar' => 'وصف محدث'],
        ];

        $response = $this->putJson(route('sections.update', ['id' => $section->id]), $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $updatedData['name']]);
        $this->assertDatabaseHas('sections', ['id' => $section->id, 'name->en' => 'Updated Section']);
    }

    public function test_can_delete_section()
    {
        $section = Section::factory()->create();

        $response = $this->deleteJson(route('sections.destroy', ['id' => $section->id]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('sections', ['id' => $section->id]);
    }
}
