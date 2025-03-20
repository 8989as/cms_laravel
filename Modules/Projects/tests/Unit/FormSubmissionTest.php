<?php

namespace Modules\Projects\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Projects\App\Models\FormSubmission;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authenticateUser(); // Call the authentication method
    }

    public function test_can_handle_dynamic_form_submission_with_files()
    {
        $section = \Modules\Projects\App\Models\Section::factory()->create();
        Storage::fake('projects_assets'); // Mock the projects_assets disk

        $file1 = UploadedFile::fake()->image('test_image1.jpg');
        $file2 = UploadedFile::fake()->create('test_document.pdf', 500); // 500 KB file

        $data = [
            'section_id' => $section->id,
            'form_data' => [
                'field1' => 'value1',
                'files' => [$file1, $file2],
            ],
        ];

        $response = $this->postJson(route('form-submissions.store'), $data);

        $response->assertStatus(201);

        // Generate expected paths
        $expectedPath1 = 'projects_assets/' . $file1->hashName();
        $expectedPath2 = 'projects_assets/' . $file2->hashName();

        // Assert files are stored in mocked storage
        Storage::disk('projects_assets')->assertExists($expectedPath1);
        Storage::disk('projects_assets')->assertExists($expectedPath2);

        // Assert the database contains the form submission record
        $this->assertDatabaseHas('form_submissions', [
            'section_id' => $section->id,
        ]);

        // Assert API response includes the saved paths
        $response->assertJsonFragment([
            'field1' => 'value1',
            'files' => [
                Storage::disk('projects_assets')->url($expectedPath1),
                Storage::disk('projects_assets')->url($expectedPath2),
            ],
        ]);
    }

    public function test_can_create_form_submission_using_factory()
    {
        // Create a form submission with related section
        $submission = FormSubmission::factory()->create();

        // Assert database record exists
        $this->assertDatabaseHas('form_submissions', [
            'id' => $submission->id,
            'section_id' => $submission->section_id,
        ]);

        // Assert form_data is properly stored
        $this->assertIsArray($submission->form_data);
    }

    public function test_can_list_form_submissions_using_factory()
    {
        // Create multiple form submissions
        $submissions = FormSubmission::factory()->count(5)->create();

        // Fetch the list of form submissions
        $response = $this->getJson(route('form-submissions.index'));
        $response->assertStatus(200);

        // Assert the correct number of submissions are retrieved
        $response->assertJsonCount(5, 'data');
    }

    public function test_can_update_form_submission_using_factory()
    {
        // Create a form submission
        $submission = FormSubmission::factory()->create();

        // Update the form submission
        $data = [
            'section_id' => $submission->section_id,
            'form_data' => [
                'field1' => 'new_value',
            ],
        ];

        $response = $this->putJson(route('form-submissions.update', $submission->id), $data);
        $response->assertStatus(200);

        // Assert database is updated
        $this->assertDatabaseHas('form_submissions', [
            'id' => $submission->id,
        ]);
        $this->assertEquals('new_value', $submission->refresh()->form_data['field1']);
    }

    public function test_can_delete_form_submission_using_factory()
    {
        // Create a form submission
        $submission = FormSubmission::factory()->create();

        // Delete the form submission
        $response = $this->deleteJson(route('form-submissions.destroy', $submission->id));
        $response->assertStatus(200);

        // Assert database record is deleted
        $this->assertDatabaseMissing('form_submissions', [
            'id' => $submission->id,
        ]);
    }
}
