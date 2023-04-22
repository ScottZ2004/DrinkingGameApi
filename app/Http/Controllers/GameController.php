<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function MakeGame(Request $request){
        return json_encode(["hello" => "hoi"]);
    }
}
