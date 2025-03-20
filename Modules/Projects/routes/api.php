<?php

use Illuminate\Support\Facades\Route;
use Modules\Projects\App\Http\Controllers\AssetController;
use Modules\Projects\App\Http\Controllers\ColorController;
use Modules\Projects\App\Http\Controllers\FormSubmissionController;
use Modules\Projects\App\Http\Controllers\PagesController;
use Modules\Projects\App\Http\Controllers\ProjectController;
use Modules\Projects\App\Http\Controllers\SectionsController;

Route::middleware(['auth:sanctum'])->group(function () {
    // Projects and Pages
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('pages', PagesController::class);

    // Sections
    Route::prefix('pages/{page_id}/sections')->group(function () {
        Route::get('/', [SectionsController::class, 'index'])->name('sections.index');
        Route::post('/', [SectionsController::class, 'store'])->name('sections.store');
    });
    Route::prefix('sections')->group(function () {
        Route::put('{id}', [SectionsController::class, 'update'])->name('sections.update');
        Route::delete('{id}', [SectionsController::class, 'destroy'])->name('sections.destroy');
    });

    // Project-specific Colors and Assets
    Route::prefix('projects/{project_id}')->group(function () {
        Route::get('colors', [ColorController::class, 'index'])->name('projects.colors.index');
        Route::post('colors', [ColorController::class, 'store'])->name('projects.colors.store');
        Route::get('assets', [AssetController::class, 'index'])->name('projects.assets.index');
        Route::post('assets', [AssetController::class, 'store'])->name('projects.assets.store');
    });

    // Global Colors and Assets
    Route::prefix('colors')->group(function () {
        Route::put('{id}', [ColorController::class, 'update'])->name('colors.update');
        Route::delete('{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
    });
    Route::prefix('assets')->group(function () {
        Route::put('{id}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
    });

    // Form Submissions
    Route::prefix('form-submissions')->group(function () {
        Route::get('/', [FormSubmissionController::class, 'index'])->name('form-submissions.index');
        Route::post('/', [FormSubmissionController::class, 'store'])->name('form-submissions.store');
        Route::put('{id}', [FormSubmissionController::class, 'update'])->name('form-submissions.update');
        Route::delete('{id}', [FormSubmissionController::class, 'destroy'])->name('form-submissions.destroy');
    });
});
