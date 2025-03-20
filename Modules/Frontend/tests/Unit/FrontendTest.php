<?php
namespace Modules\Frontend\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Projects\App\Models\Page;
use Modules\Projects\App\Models\Project;
use Modules\Projects\App\Models\Section;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->authenticateUser();
    // }

    public function test_can_get_project_with_pages_and_sections()
    {
        $project = Project::factory()->has(
            Page::factory()->has(Section::factory()->count(3))->count(2)
        )->create(['key' => 'project_key']);

        $response = $this->getJson(route('frontend.get-project', ['project_key' => 'project_key']));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'url',
                    'key',
                    'description',
                    'icon',
                    'pages' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'sections' => [
                                '*' => [
                                    'id',
                                    'name',
                                    'description',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Test retrieving a page by page key and project key with its sections.
     */
    public function test_can_get_page_with_sections_by_page_key_and_project_key()
    {
        $project = Project::factory()->create(['key' => 'project_key']);
        $page    = Page::factory()->has(Section::factory()->count(3))->create([
            'key'        => 'page_key',
            'project_id' => $project->id,
        ]);

        $response = $this->getJson(route('frontend.get-page', [
            'page_key'    => 'page_key',
            'project_key' => 'project_key',
        ]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'sections' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Test retrieving a section by section key and project key.
     */
    public function test_can_get_section_with_page_and_project_by_section_key_and_project_key()
    {
        $project = Project::factory()->create(['key' => 'project_key']);
        $page    = Page::factory()->create(['key' => 'page_key', 'project_id' => $project->id]);
        $section = Section::factory()->create(['key' => 'section_key', 'page_id' => $page->id]);

        $response = $this->getJson(route('frontend.get-section', [
            'section_key' => 'section_key',
            'project_key' => 'project_key',
        ]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'page' => [
                        'id',
                        'name',
                        'description',
                        'project' => [
                            'id',
                            'name',
                            'url',
                            'key',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Test handling a project not found.
     */
    public function test_returns_error_when_project_not_found()
    {
        $response = $this->getJson(route('frontend.get-project', ['project_key' => 'invalid_key']));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Project not found']);
    }

    /**
     * Test handling a page not found.
     */
    public function test_returns_error_when_page_not_found()
    {
        $response = $this->getJson(route('frontend.get-page', [
            'page_key'    => 'invalid_page_key',
            'project_key' => 'invalid_project_key',
        ]));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Page not found']);
    }

    /**
     * Test handling a section not found.
     */
    public function test_returns_error_when_section_not_found()
    {
        $response = $this->getJson(route('frontend.get-section', [
            'section_key' => 'invalid_section_key',
            'project_key' => 'invalid_project_key',
        ]));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Section not found']);
    }
}
