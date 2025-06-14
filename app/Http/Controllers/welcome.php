<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class Welcome extends Controller
{
    public function index()
    {
        $links = Link::with('user')->get();
        
        return view('welcome', [
            'doc' => 'home',
            'css' => 'home',
            'links' => $links
        ]);
    }
}
