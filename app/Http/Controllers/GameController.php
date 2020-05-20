<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\GameStore;
use App\Http\Requests\GameUpdate;
use App\SubGame;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Game::all();
    }

    public function store(GameStore $request)
    {
        $game = new Game();
        $game->title = $request->title;
        $game->description = $request->description;
        $game->save();
    }

    public function show(Game $game)
    {
        //
    }

    public function update(GameUpdate $request, $id)
    {
        $game = Game::where('id', $id)->first();
        $game->title = $request->title;
        $game->description = $request->description;
        $game->save();
        return $game;
    }

    public function destroy($id)
    {
        Game::find($id)->delete();
    }
}
