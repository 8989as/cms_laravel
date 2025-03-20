<?php

namespace Modules\Projects\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Projects\App\Http\Requests\Assets\StoreAssetRequest;
use Modules\Projects\App\Http\Requests\Assets\UpdateAssetRequest;
use Modules\Projects\Services\AssetService;

class AssetController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function index($projectId)
    {
        $assets = $this->assetService->getWhere(['project_id' => $projectId]);
        return app('ResponseHelper')::successResponse($assets, 'Assets retrieved successfully');
    }

    public function store(StoreAssetRequest $request, $projectId)
    {
        \Log::info('StoreAssetRequest received', ['project_id' => $projectId]);

        $validatedData = $request->validated();
        \Log::info('Request data validated', ['validated_data' => $validatedData]);

        if ($request->hasFile('image')) {
            \Log::info('Image file found in request');
            $imagePath = app('GalleryHelper')::saveAsset($request->file('image'), 'projects_assets');
            \Log::info('Image saved', ['image_path' => $imagePath]);
            $validatedData['image'] = $imagePath;
        }

        $validatedData['project_id'] = $projectId;
        \Log::info('Project ID added to validated data', ['validated_data' => $validatedData]);

        $asset = $this->assetService->create($validatedData);
        \Log::info('Asset created', ['asset' => $asset]);

        return app('ResponseHelper')::successResponse($asset, 'Asset added successfully', 201);
    }

    public function update(UpdateAssetRequest $request, $id)
    {
        $asset = $this->assetService->find($id);

        if ($request->hasFile('image')) {
            app('GalleryHelper')::deleteAsset($asset->image, 'project_assets');
            $imagePath = app('GalleryHelper')::saveAsset($request->file('image'), 'projects_assets');
        } else {
            $imagePath = $asset->image;
        }

        $validatedData = $request->validated();
        $validatedData['image'] = $imagePath;

        $updatedAsset = $this->assetService->update($id, $validatedData);

        return app('ResponseHelper')::successResponse($updatedAsset, 'Asset updated successfully');
    }

    public function destroy($id)
    {
        $this->assetService->delete($id);
        return app('ResponseHelper')::successResponse(null, 'Asset deleted successfully');
    }
}
