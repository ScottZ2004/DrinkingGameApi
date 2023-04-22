<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGamesRequest;
use App\Models\Games;
use App\Models\Players;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function CreateGame(CreateGamesRequest $request){
        $pin = $this->CreatePin();
        $game = new Games;
        
        $game->game_pin = $pin;
        $game->game_type = $request->game_type;
        $game->admin_id = 0;
        $game->save();
        $game->admin_id = $this->CreatePlayer($game->id, $request->name, true);
        $game->save();
        return json_encode([
            "game_pin" => $game->game_pin,
            "game_id" => $game->id,
            "admin_id" => $game->admin_id,
            "game_type" => $game->game_type
        ]);
    }

    private function CreatePin(){
        do {
            $pin = rand(1000, 9999);
            $game = Games::where('game_pin', $pin)->first();
        } while ($game);

        return $pin;
    }

    private function CreatePlayer($game_id, $name, bool $is_admin=false):int{
        $players = new Players;
        $players->game_id = $game_id;
        $players->name = $name;
        $players->is_admin = $is_admin;
        $players->save();
        return $players->id;
    }

    public function JoinGame(Request $request){

    }
}
