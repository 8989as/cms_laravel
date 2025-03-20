<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\App\Http\Controllers\FrontendController;

Route::prefix('ui')->group(function () {
    Route::get('/get-project', [FrontendController::class, 'getProject'])->name('frontend.get-project');
    Route::get('/get-page', [FrontendController::class, 'getPage'])->name('frontend.get-page');
    Route::get('/get-section', [FrontendController::class, 'getSection'])->name('frontend.get-section');
});
