<?php
use  App\Http\Controllers\loginUser as login;
use App\Http\Controllers\registerUser as register;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Leaderboard as lead;
use App\Http\Controllers\user;
use App\Http\Controllers\welcome;
use App\Http\Controllers\admin;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-linkschecker/{token}', function ($token) {
    if ($token !== env('LINKCHECKER_TOKEN')) {
        abort(404, 'Unauthorized');
    }

    Artisan::call('app:linkschecker');

    return 'Link checker executed.';
});

Route::get('/', [Welcome::class,"index"]);
// login page logic class
Route::get('/login',[login::class,'show']);
Route::post("/login", [login::class, 'login'])->name('login');
Route::get("/logout",[login::class,'logout']);

// register page logic class 
Route::post("/register",[register::class,"register"])->name("register");
Route::get('/register',[register::class,'show']);


Route::get('/leaderboard',[lead::class,'index']);



// funncion dashboard users
Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/dashboard', [user::class, "index"]);
    Route::post('/dashboard', [user::class, "addLink"])->name('useradd');
    Route::delete('/dashboard', [user::class, "dellink"])->name('dawdel');
    Route::post('/dashboard/bulk', [user::class, "addbulk"])->name('bulk');
});

// function dashboard admin
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin',[admin::class,"index"]);
    Route::delete('/admin', [admin::class, "dellink"])->name('dellink');
    Route::post('/admin',[admin::class,"addlinksadmin"])->name('addlink');
    Route::post('/admin/bulk', [user::class, "addbulk"])->name('bulkadmin');

});
Route::fallback(function (){
    return view('404');
});
