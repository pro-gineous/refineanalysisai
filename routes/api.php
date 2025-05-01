<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// AI Assistant API Routes
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/projects', function (Request $request) {
        $projects = \App\Models\Project::where('owner_id', $request->user()->id)->get();
        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    });
});
