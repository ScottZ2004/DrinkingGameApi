<?php

namespace App\Http\Controllers;

use App\Models\GameType;
use Illuminate\Http\Request;

class GameTypeController extends Controller
{
    public function GameTypes(){
        $gameTypes = GameType::all();
        return response()->json($gameTypes );
    }
}
