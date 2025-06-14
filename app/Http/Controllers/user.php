<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class User extends Controller
{
   // send bulk with json format 
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
   public function index() {
      $userId = auth()->id();
      $whoami = auth()->user(); 
      $userLinks = Link::where('postby', $userId)
         ->select('link', 'title', 'created_at','id','catagory')
         ->orderBy('updated_at', 'desc')
         ->paginate(5, ['*'], "link_total");

      return view("login.dashboar_user", [
         'doc' => 'Dashboard',
         'css' => 'user',
         'mylink' => $userLinks,
         'whoami' => $whoami 
      ]);
   }

   public function addLink(Request $request){
      $validated = $request->validate([
         'title' => 'required|string|unique:links|min:5|max:100',
         'category' => 'required|in:marketplace,chat room,forums,service,search,directory link,youtube,uploader,hosting,news,other',
         'link' => 'required|url|max:2048|unique:links',
      ]);

      Link::create([
         'title' => $validated['title'],
         'catagory' => $validated['category'],
         'link' => $validated['link'],
         'postby' => auth()->id(),
      ]);

      return back()->with(['message'=> 'Link title: '.$validated['title'].' added successfully','status'=>'success']);
   }
   public function dellink(Request $request){
      // Validate the request data with proper error handling
      $validated = $request->validate([
         'link_id' => 'required|exists:links,id',
      ]);

      try {
         // Find the link with proper authorization check
         $link = Link::findOrFail($validated['link_id']);
         
         // Verify the authenticated user owns this link
         if ($link->postby !== auth()->id()) {
            return back()->with([
               'status' => 'danger',
               'message' => 'Unauthorized: You can only delete your own links'
            ]);
         }

         // Store link info before deletion for feedback
         $linkTitle = $link->title;
         
         // Perform deletion with transaction for safety
         \DB::transaction(function() use ($link) {
            $link->delete();
         });

         // Return success response with deleted link info
         return back()->with([
            'status' => 'success',
            'message' => "Link '{$linkTitle}' was successfully deleted"
         ]);

      } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
         // Handle case where link doesn't exist
         return back()->with([
            'status' => 'danger',
            'message' => 'Link not found or already deleted'
         ]);
      } catch (\Exception $e) {
         // Handle any other unexpected errors
         return back()->with([
            'status' => 'danger',
            'message' => 'Failed to delete link: ' . $e->getMessage()
         ]);
      }
   }
}
