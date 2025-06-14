<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Link;
use Illuminate\Support\Facades\DB;

class Leaderboard extends Controller
{
    public function index()
    {
       
        ini_set('memory_limit', '256M');
        $totaluser = User::all();
        $link = count(Link::all());
        $leaderboard = User::select('users.id', 'users.username', 'users.created_at', DB::raw('COUNT(links.id) as total_links'))
            ->leftJoin('links', 'users.id', '=', 'links.postby')
            ->where('links.postby', '!=', 0)
            ->limit('10')
            ->groupBy('users.id', 'users.username', 'users.created_at')
            ->orderByDesc('total_links')
            ->get();
   

     
        return view('leaderboard', [
            'leaderboard' => $leaderboard,
            'total'=>$totaluser,
            'doc' => 'leaderboard',
            'link' => $link,
            'css' => 'leaderboard'
        ]);
    }
}
