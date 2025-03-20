<?php

namespace Modules\Projects\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Projects\App\Http\Requests\Pages\StorePageRequest;
use Modules\Projects\App\Http\Requests\Pages\UpdatePageRequest;
use Modules\Projects\Services\PagesService;

class PagesController extends Controller
{
    protected $pagesService;

    public function __construct(PagesService $pagesService)
    {
        $this->pagesService = $pagesService;
    }

    public function index()
    {
        $pages = $this->pagesService->getPaginated();
        return app('ResponseHelper')::paginatedResponse($pages, 'Pages retrieved successfully');
    }

    public function store(StorePageRequest $request)
    {
        $validatedData = $request->validated();
        $page = $this->pagesService->create($validatedData);
        return app('ResponseHelper')::successResponse($page, 'Page created successfully', 201);
    }

    public function show($id)
    {
        try {
            $page = $this->pagesService->find($id);
            return app('ResponseHelper')::successResponse($page, 'Page retrieved successfully');
        } catch (\Exception $e) {
            return app('ResponseHelper')::errorResponse('Page not found', 404);
        }
    }

    public function update(UpdatePageRequest $request, $id)
    {
        $validatedData = $request->validated();
        $updatedPage = $this->pagesService->update($id, $validatedData);
        return app('ResponseHelper')::successResponse($updatedPage, 'Page updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->pagesService->delete($id);
            return app('ResponseHelper')::successResponse(null, 'Page deleted successfully');
        } catch (\Exception $e) {
            return app('ResponseHelper')::errorResponse('Page not found', 404);
        }
    }
}
