<?php

namespace Modules\Projects\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Projects\App\Http\Requests\Sections\StoreSectionRequest;
use Modules\Projects\App\Http\Requests\Sections\UpdateSectionRequest;
use Modules\Projects\Services\SectionsService;

class SectionsController extends Controller
{
    protected $sectionsService;

    public function __construct(SectionsService $sectionsService)
    {
        $this->sectionsService = $sectionsService;
    }

    public function index($pageId)
    {
        $sections = $this->sectionsService->getWhere(['page_id' => $pageId]);
        return app('ResponseHelper')::successResponse($sections, 'Sections retrieved successfully');
    }

    public function store(StoreSectionRequest $request, $pageId)
    {
        $validatedData = $request->validated();
        $validatedData['page_id'] = $pageId;
        $section = $this->sectionsService->create($validatedData);
        return app('ResponseHelper')::successResponse($section, 'Section created successfully', 201);
    }

    public function update(UpdateSectionRequest $request, $id)
    {
        $validatedData = $request->validated();
        $section = $this->sectionsService->update($id, $validatedData);
        return app('ResponseHelper')::successResponse($section, 'Section updated successfully');
    }

    public function destroy($id)
    {
        $this->sectionsService->delete($id);
        return app('ResponseHelper')::successResponse(null, 'Section deleted successfully');
    }
}
