<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\GameType;
use Illuminate\Http\Request;

class GameTypeController extends Controller
{
    public function GameType(Request $request){
        if (!isset($request->game_pin))
            return response()->json(['error' => 'You need to provide a game_pin'], 400);
        $game = Games::where('game_pin', $request->game_pin)->first();
        if (!isset($game))
            return response()->json(['error' => 'Game not found'], 404);
        if (!isset($game->game_type_id))
            return response()->json(['error' => 'There is no game type for this game, please try again'], 404);
        $gameType = GameType::where('id', $game->game_type_id)->first();
        if (!isset($gameType))
            return response()->json(['error' => 'No game type has been found'], 400);
        return response()->json($gameType);
    }

    public function GameTypes(){
        $gameTypes = GameType::all();
        return response()->json($gameTypes );
    }
}
