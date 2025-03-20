<?php

namespace Modules\Projects\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Projects\App\Http\Requests\Colors\StoreColorRequest;
use Modules\Projects\App\Http\Requests\Colors\UpdateColorRequest;
use Modules\Projects\Services\ColorService;

class ColorController extends Controller
{
    protected $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    /**
     * Get all colors for a specific project.
     */
    public function index($projectId)
    {
        $colors = $this->colorService->getWhere(['project_id' => $projectId]);
        return app('ResponseHelper')::successResponse($colors, 'Colors retrieved successfully');
    }

    /**
     * Store a new color for a project.
     */
    public function store(StoreColorRequest $request, $projectId)
    {
        $validatedData = $request->validated();
        $validatedData['project_id'] = $projectId;

        $color = $this->colorService->create($validatedData);

        return app('ResponseHelper')::successResponse($color, 'Color added successfully', 201);
    }

    /**
     * Update an existing color.
     */
    public function update(UpdateColorRequest $request, $id)
    {
        $validatedData = $request->validated();

        $updatedColor = $this->colorService->update($id, $validatedData);

        return app('ResponseHelper')::successResponse($updatedColor, 'Color updated successfully');
    }

    /**
     * Delete a specific color.
     */
    public function destroy($id)
    {
        $this->colorService->delete($id);

        return app('ResponseHelper')::successResponse(null, 'Color deleted successfully');
    }
}
