<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function scoreUser()
    {
        $max = DB::select('
            SELECT g.id, g.title, concat(first_name, " ",last_name) AS full_name, score, m.created_at
            FROM users u inner join msgs ms ON u.id=ms.user_id
                INNER JOIN matches m ON m.id=ms.match_id
                INNER JOIN games g ON g.id=m.game_id
            WHERE score = (SELECT MAX(score)
                                FROM msgs ms2
                                INNER JOIN matches m2 ON m2.id=ms2.match_id
                                WHERE m2.game_id=g.id
                                HAVING MAX(score)<>0)
            ORDER BY m.created_at DESC
        ');
        $min = DB::select('
            SELECT g.id, g.title, concat(first_name, " ",last_name) AS full_name, score, m.created_at
            FROM users u inner join msgs ms ON u.id=ms.user_id
                INNER JOIN matches m ON m.id=ms.match_id
                INNER JOIN games g ON g.id=m.game_id
            WHERE score = (SELECT MIN(score)
                                FROM msgs ms2
                                INNER JOIN matches m2 ON m2.id=ms2.match_id
                                WHERE m2.game_id=g.id)
            ORDER BY m.created_at DESC
        ');
        return response(array(
            'max' => $max,
            'min' => $min,
        ), 200);
        return DB::select('
            call _sp_max_five(3);
        ');
    }

    public function gamePopular()
    {
        return DB::table('games as g')
            ->join('matches as m', 'g.id', '=', 'm.game_id')
            ->select(DB::raw('title, count(m.game_id) as quantity'))
            ->groupBy('title')
            ->get();
    }

    public function gameScore()
    {
        return DB::select('
            SELECT g.title, MIN(score) as min, MAX(score) as max
            FROM games g LEFT JOIN matches m ON g.id=m.game_id
                INNER JOIN msgs ms ON m.id=ms.match_id
            GROUP BY g.id
        ');
    }
}
