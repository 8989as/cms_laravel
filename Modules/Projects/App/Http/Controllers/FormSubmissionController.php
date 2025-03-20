<?php

namespace Modules\Projects\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Projects\App\Http\Requests\FormSubmission\StoreFormSubmissionRequest;
use Modules\Projects\App\Http\Requests\FormSubmission\UpdateFormSubmissionRequest;
use Modules\Projects\Services\FormSubmissionService;
use Modules\Projects\Transformers\FormSubmissionTransformer;

class FormSubmissionController extends Controller
{
    protected $formSubmissionService;

    public function __construct(FormSubmissionService $formSubmissionService)
    {
        $this->formSubmissionService = $formSubmissionService;
    }

    // public function index()
    // {
    //     $submissions = $this->formSubmissionService->getAll();
    //     return app('ResponseHelper')::successResponse($submissions, 'Form submissions retrieved successfully');
    // }

    public function index()
    {
        $submissions = $this->formSubmissionService->getAll();
        return app('ResponseHelper')::successResponse(
            FormSubmissionTransformer::collection($submissions),
            'Form submissions retrieved successfully'
        );
    }
    
    public function store(StoreFormSubmissionRequest $request)
    {
        $validatedData = $request->validated();

        // Process form_data recursively
        array_walk_recursive($validatedData, function (&$item) {
            if ($item instanceof \Illuminate\Http\UploadedFile) {
                try {
                    // Save the asset using the projects_assets folder and disk
                    $assetPath = app('GalleryHelper')::saveAsset($item, 'projects_assets');
                    $item = $assetPath;
                } catch (\Exception $e) {
                    // Log error and throw a validation exception
                    \Log::error('Error saving uploaded file', ['error' => $e->getMessage()]);
                    abort(500, 'Failed to save uploaded file.');
                }
            }
        });

        // Create the form submission
        $submission = $this->formSubmissionService->create($validatedData);

        return app('ResponseHelper')::successResponse($submission, 'Form submission created successfully', 201);
    }

    // public function store(StoreFormSubmissionRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     array_walk_recursive($validatedData, function (&$item, $key) {
    //         if ($item instanceof \Illuminate\Http\UploadedFile) {
    //             try {
    //                 $assetPath = app('GalleryHelper')::saveAsset($item, 'projects_assets');
    //                 $item = $assetPath;
    //             } catch (\Exception $e) {
    //                 \Log::error('Error saving uploaded file', ['error' => $e->getMessage()]);
    //                 abort(500, 'Failed to save uploaded file.');
    //             }
    //         }
    //     });

    //     $submission = $this->formSubmissionService->create($validatedData);

    //     return app('ResponseHelper')::successResponse($submission, 'Form submission created successfully', 201);
    // }

    public function update(UpdateFormSubmissionRequest $request, $id)
    {
        $validatedData = $request->validated();

        array_walk_recursive($validatedData, function (&$item) {
            if ($item instanceof \Illuminate\Http\UploadedFile) {
                $assetPath = app('GalleryHelper')::saveAsset($item, 'projects_assets');
                $item = $assetPath;
            }
        });

        $submission = $this->formSubmissionService->update($id, $validatedData);

        return app('ResponseHelper')::successResponse($submission, 'Form submission updated successfully');
    }

    public function destroy($id)
    {
        $this->formSubmissionService->delete($id);
        return app('ResponseHelper')::successResponse(null, 'Form submission deleted successfully');
    }
}
