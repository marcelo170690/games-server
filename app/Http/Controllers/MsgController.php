<?php

namespace App\Http\Controllers;

use App\Http\Requests\MsgStore;
use App\Match;
use App\Msg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MsgController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        return DB::table('matches as m')
            ->join('msgs', 'm.id', '=', 'msgs.match_id')
            ->join('users as u', 'u.id', '=', 'msgs.user_id')
            ->where('m.id', $request->match_id)
            ->select('u.id', 'first_name', 'last_name', 'score', 'msgs.id as msg_id')
            ->orderBy('score', 'desc')
            ->get();
    }

    public function store(MsgStore $request)
    {

    }

    public function show(Msg $msg)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $msg = Msg::where('id', $id)->first();
        $msg->score = $request->score;
        $msg->save();

        return response()->json(DB::table('msgs as m')
            ->join('users as u', 'u.id', '=', 'm.user_id')
            ->where('m.id', $id)
            ->select('u.id', 'first_name', 'last_name', 'score', 'm.id as msg_id')
            ->first(), 200);
    }

    public function destroy(Msg $msg)
    {
        //
    }
}
