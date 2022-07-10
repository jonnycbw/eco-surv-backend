<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BreedController, UserController, ParkController};
use App\Models\{BreedClient, Breed};
use Illuminate\Support\Arr;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// utilise the apiResource method to simplify REST
Route::apiResource('breeds', BreedController::class);
Route::apiResource('parks', ParksController::class);
Route::apiResource('users', UsersController::class);


// routes for accessing the dog.ceo API from an external API (non RESTful)
Route::get('breed', [BreedController::class, 'listAllFromAPI']);
Route::get('breed/random', [BreedController::class, 'random']);
Route::get('breed/{breed_id}', [BreedController::class, 'showFromAPI']);
Route::get('breed/{breed_id}/image', [BreedController::class, 'imageForBreed']);
