<?php

namespace Modules\Projects\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Projects\Services\ProjectService;
use App\Http\Controllers\Controller;
use Modules\Projects\App\Http\Requests\Projects\StoreProjectRequest;
use Modules\Projects\App\Http\Requests\Projects\UpdateProjectRequest;
class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getPaginated();
        return app('ResponseHelper')::paginatedResponse($projects, 'Projects retrieved successfully');
    }

    public function store(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('icon')) {
            // Save the icon using the GalleryHelper
            $iconPath = app('GalleryHelper')::saveAsset($request->file('icon'), 'projects_icons'); 
            $validatedData['icon'] = $iconPath;
        }
        $project = $this->projectService->create($validatedData);
        return app('ResponseHelper')::successResponse($project, 'Project created successfully', 201);
    }

    public function show($id)
    {
        try {
            $project = $this->projectService->find($id);
            return app('ResponseHelper')::successResponse($project, 'Project retrieved successfully');
        } catch (\Exception $e) {
            return app('ResponseHelper')::errorResponse('Project not found', 404);
        }
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        // try {
            
            $project = $this->projectService->find($id);
            // 
            // If the icon is uploaded, delete the old one and save the new one
            if ($request->hasFile('icon')) {
                app('GalleryHelper')::deleteAsset($project->icon, 'projects_icons');
                $iconPath = app('GalleryHelper')::saveAsset($request->file('icon'), 'projects_icons');
            } else {
                $iconPath = $project->icon;
            }
            
            $validatedData = $request->validated();
            $validatedData['icon'] = $iconPath;
            
            $updatedProject = $this->projectService->update($id, $validatedData);
            return app('ResponseHelper')::successResponse($updatedProject, 'Project updated successfully');
        // } catch (\Exception $e) {
        //     return app('ResponseHelper')::errorResponse('Project not found', 404);
        // }
    }

    public function destroy($id)
    {
        try {
            $this->projectService->delete($id);
            return app('ResponseHelper')::successResponse(null, 'Project deleted successfully');
        } catch (\Exception $e) {
            return app('ResponseHelper')::errorResponse('Project not found', 404);
        }
    }
}