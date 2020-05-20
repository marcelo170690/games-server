<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchStore;
use App\Match;
use App\Msg;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return DB::table('matches as m')
            ->join('users as u', 'm.user_id', '=', 'u.id')
            ->join('games as g', 'm.game_id', '=', 'g.id')
            ->select('m.id', 'first_name', 'last_name', 'm.created_at', 'state', 'g.title')
            ->orderBy('id', 'desc')
            ->paginate(4);
    }

    public function store(MatchStore $request)
    {
        $match = new Match();
        $match->state = '0';
        $match->user_id = Auth::user()->id;
//        $match->user_id = $user->id;
        $match->game_id = $request->game_id;
        $match->save();

        $match_id = Match::max('id');
        foreach ($request->user_id as $user_id){
            $msg = new Msg();
            $msg->score = 0;
            $msg->match_id = $match_id;
            $msg->user_id = $user_id;
            $msg->save();
        }

    }

    public function show(Match $match)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $match = Match::where('id', $id)->first();
        $match->state = $request->state;
        $match->save();
    }

    public function destroy($id)
    {
        Match::find($id)->delete();
    }
}
