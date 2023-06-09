<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameTypeController;
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

Route::middleware("api_key")->group(function(){
    Route::post("/v1/creategame", [GameController::class, "CreateGame"])->name('createGame');
    Route::post("/v1/joingame", [GameController::class, "JoinGame"])->name('joinGame');

    Route::get("/v1/gametype", [GameTypeController::class, "GameType"])->name('gameType');
    Route::get('/v1/gametypes', [GameTypeController::class, 'GameTypes'])->name('gameTypes');

    Route::delete('/v1/inactive-games', [GameController::class, 'DeleteInactiveGames'])->name('deleteInactiveGames');
});

