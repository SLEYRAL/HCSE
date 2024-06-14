<?php

use App\Enum\StatusProfile;
use App\Http\Resources\ProfilePublicResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth:sanctum')->post('admin/comment', [CommentController::class, 'store']);

Route::middleware('auth:sanctum')->post('admin/profile', [ProfileController::class, 'store']);
Route::middleware('auth:sanctum')->put('admin/profile/{profile}', [ProfileController::class, 'update']);
Route::middleware('auth:sanctum')->delete('admin/profile/{profile}', [ProfileController::class, 'delete']);

Route::get('/profile', function (Request $request) {
    return ProfilePublicResource::collection(
        Profile::where('status', StatusProfile::Active)->get());
});
