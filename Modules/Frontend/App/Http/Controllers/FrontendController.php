<?php

namespace Modules\Frontend\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\Services\ProjectService;
use Modules\Frontend\Services\PageService;
use Modules\Frontend\Services\SectionService;
use Modules\Frontend\Transformers\ProjectTransformer;
use Modules\Frontend\Transformers\PageTransformer;
use Modules\Frontend\Transformers\SectionTransformer;

class FrontendController extends Controller
{
    protected $projectService;
    protected $pageService;
    protected $sectionService;

    public function __construct(ProjectService $projectService, PageService $pageService, SectionService $sectionService)
    {
        $this->projectService = $projectService;
        $this->pageService = $pageService;
        $this->sectionService = $sectionService;
    }

    public function getProject(Request $request)
    {
        $request->validate(['project_key' => 'required|string']);
        $project = $this->projectService->getProjectWithRelations($request->project_key);

        if (!$project) {
            return app('ResponseHelper')::errorResponse('Project not found', 404);
        }

        return app('ResponseHelper')::successResponse($project, 'Project retrieved successfully', 200);
        // return app('ResponseHelper')::paginatedResponse($project, 'Project retrieved successfully');
    }

    public function getPage(Request $request)
    {
        $request->validate([
            'page_key' => 'required|string',
            'project_key' => 'required|string',
        ]);

        $page = $this->pageService->getPageWithRelations($request->page_key, $request->project_key);

        if (!$page) {
            return app('ResponseHelper')::errorResponse('Page not found', 404);
        }
        return app('ResponseHelper')::successResponse($page,'Pages retrieved successfully', 201);
    }

    public function getSection(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string',
            'project_key' => 'required|string',
        ]);

        $section = $this->sectionService->getSectionWithRelations($request->section_key, $request->project_key);

        if (!$section) {
            return app('ResponseHelper')::errorResponse('Section not found', 404);
        }

        return app('ResponseHelper')::successResponse($section, 'Section retrieved successfully', 200);
    }
}
