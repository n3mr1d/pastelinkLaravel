<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;

class admin extends Controller
{
    public function index()
    {
        // Get all links with pagination
        $links = Link::paginate(5, ['*'], 'links_table');
        
        // Get non-admin users with pagination
        $users = User::where('is_admin', '!=', 1)
            ->withCount('links')
            ->paginate(5, ['*'], 'user_table');
        // Get active sessions with pagination
        $activeSessions = Session::where('user_id', '!=', auth()->id())
            ->paginate(5, ['*'], 'session_table');

        return view("login.dashboar_admin", [
            'doc' => 'admin',
            'css' => 'admin',
            'link' => $links,
            'user' => $users,
            'sessions' => $activeSessions
        ]);
    }
    public function addlinksadmin(Request $request){
        $validlink = $request->validate([
            'title'=>'required|string|unique:links,title|min:4|max:10',
            'link'=>'required|string|unique:links,link',
            'category' => 'required|in:marketplace,chat room,forums,service,search,directory link,youtube,uploader,hosting,news,other',
        ]);
        Link::create([
            'title'=>$validlink['title'],
            'category' => $validlink['category'],

            'link'=>$validlink['link'],
            'postby'=>auth()->id()
        ]);
        return back()->with(['status'=>'success', 'message' => 'Add Links :'.$validlink['title'].' to database success']);
    }
    // deleted link on admin
    public function dellink(Request $request)
    {
        $user = auth()->user();
        if ($user && $user->is_admin) {
            $valid = $request->validate([
                'link_id' => 'required|exists:links,id',
            ]);

            $link = Link::find($valid['link_id']);
            $link->delete();
            
            return back()->with([
                'status' => 'success',
                'message' => 'Link deleted successfully. Link title:'. $link['title'] 
            ])->withInput($request->except(['_token', '_method']));
        }
        abort(403, 'Unauthorized action.');
    }
}

