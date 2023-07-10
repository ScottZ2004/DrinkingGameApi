<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGamesRequest;
use App\Http\Requests\JoinGameRequest;
use App\Models\Games;
use App\Models\GameType;
use App\Models\Players;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function CreateGame(CreateGamesRequest $request){
        $pin = $this->CreatePin();
        $game = new Games;
        $gameType = GameType::where('id', $request->game_type_id)->first();
        if (!isset($gameType))
            return response()->json(['errors' => ['game_type_id' => ['There is no game with this id']]], 404);
        if ($gameType->active === 0)
            return response()->json(['errors' => ['game_type_id' => ['This game is not active']]], 404);

        $game->game_pin = $pin;
        $game->game_type_id = $request->game_type_id;
        $game->admin_id = 0;
        $game->save();
        $game->admin_id = $this->CreatePlayer($game->id, $request->name, true);
        $game->save();
        return response()->json([
            "game_pin" => $game->game_pin,
            "game_id" => $game->id,
            "admin_id" => $game->admin_id,
            "game_type_id" => $game->game_type_id,
            "game_type" => $gameType->name,
            "name" => $request->name
        ]);
    }

    private function CreatePin(){
        do {
            $pin = rand(100000, 999999);
            $game = Games::where('game_pin', $pin)->first();
        } while ($game);

        return $pin;
    }

    public function JoinGame(JoinGameRequest $request){
        // checks if game exists
        $game = Games::where("game_pin", $request->game_pin)->first();
        if (empty($game))
            return response()->json(['error' => 'Invalid Game Pin'], 400);
        $existingPlayer = Players::where("name", $request->name)->where("game_id", $game->id)->first();
        //checks if player has the same name
        if(!empty($existingPlayer))
            return response()->json(["error" => 'Someone Already has this name'], 400);

        $player = $this->CreatePlayer($game->id, $request->name);
        return response()->json(
            [
                "name" => $request->name,
                "player_id" =>$player ,
                "game_id" => $game->id,
                "game_type" => $game->type
            ]
        );
    }

    private function CreatePlayer($gameId, $name, bool $isAdmin=false):int{
        $players = new Players;
        $players->game_id = $gameId;
        $players->name = $name;
        $players->is_admin = $isAdmin;
        $players->save();
        return $players->id;
    }

    public function DeleteInactiveGames(){

    }


}
