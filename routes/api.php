<?php

use App\Enum\StatusProfile;
use App\Http\Resources\ProfilePublicResource;
use App\Models\Profile;
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

Route::get('/profile', function (Request $request) {
    return ProfilePublicResource::collection(
        Profile::where('status', StatusProfile::Active)->get());
});
