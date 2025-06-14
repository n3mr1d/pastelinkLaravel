<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;

class admin extends Controller
{
    public function addbulk(Request $request) {
        $request->validate([
           'json_data' => 'nullable|json',
           'json_file' => 'nullable|file|mimes:json|max:2048'
        ]);
  
        // Get JSON data from either textarea or file
        if ($request->hasFile('json_file')) {
           $jsonData = json_decode(file_get_contents($request->file('json_file')->getRealPath()), true);
        } else {
           $jsonData = json_decode($request->json_data, true);
        }
  
        if (!is_array($jsonData)) {
           return back()->with(['status'=>'error', 'message'=>'Invalid JSON format. Expected array of link objects']);
        }
  
        $validatedLinks = [];
        $overwrite = $request->has('overwrite');
        
        foreach ($jsonData as $link) {
           $rules = [
              'link' => 'required|url|max:2048',
              'title' => 'nullable|string|max:255',
              'category' => 'required|in:marketplace,chat room,forums,service,search,directory link,youtube,uploader,news,hosting,other'
           ];
  
           if (!$overwrite) {
              $rules['link'] .= '|unique:links,link';
           }
  
           $validator = validator($link, $rules);
  
           if ($validator->fails()) {
              return back()->with(['status'=>'error', 'message'=>'Validation failed: '.$validator->errors()->first()]);
           }
  
           if ($overwrite) {
              Link::updateOrCreate(
                 ['link' => $link['link']],
                 [
                    'title' => $link['title'] ?? null,
                    'catagory' => $link['category'],
                    'postby' => $request->user()->id
                 ]
              );
           } else {
              $validatedLinks[] = [
                 'link' => $link['link'],
                 'title' => $link['title'] ?? null,
                 'catagory' => $link['category'],
                 'postby' => $request->user()->id
              ];
           }
        }
  
        if (!$overwrite && count($validatedLinks) > 0) {
           Link::insert($validatedLinks);
        }
  
        $count = $overwrite ? count($jsonData) : count($validatedLinks);
        return back()->with(['status'=>'success', 'message'=>'Successfully processed '.$count.' links!']);
     }
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
            'catagory' => $validlink['category'],

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

