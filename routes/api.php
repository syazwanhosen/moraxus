<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\VideoWatchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/feedback/{id}', [FeedbackController::class, 'index']);

Route::post('/store-feedback', [FeedbackController::class, 'store']);

Route::get('/employees/{id}', [EmployeeController::class, 'index']);

Route::post('/store-employee', [EmployeeController::class, 'store']);

Route::get('/get-employee/{id}', [EmployeeController::class, 'show']);

Route::put('/update-employee/{id}', [EmployeeController::class, 'update']);

Route::post('/delete-employee/{id}', [EmployeeController::class, 'destroy']);

Route::get('/modules/{id}', [ModuleController::class, 'index']);

Route::post('/store-module', [ModuleController::class, 'store']);

Route::post('/delete-module/{id}', [ModuleController::class, 'destroy']);

Route::get('/get-module/{id}', [ModuleController::class, 'show']);

Route::get('/get-module-by-organization-id/{id}', [ModuleController::class, 'showModuleByOrganizationId']);

Route::get('/get-module-by-stage/{organizationId}/{stage}', [ModuleController::class, 'showModuleByStage']);

Route::post('/update-module', [ModuleController::class, 'update']);

Route::get('/download/{file}', [ModuleController::class, 'download']);

Route::get('/get-dashboard/{id}', [DashboardController::class, 'show']);

Route::get('/get-sprints/{id}', [DashboardController::class, 'employeeProgress']);

Route::post('/store-file-download', [FileDownloadController::class, 'store']);

Route::get('/file-download/{id}', [FileDownloadController::class, 'index']);

Route::post('/store-video-watch', [VideoWatchController::class, 'store']);

Route::get('/video-watch/{id}', [VideoWatchController::class, 'index']);
