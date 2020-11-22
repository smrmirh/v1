<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("test",function(){
    //return \App\Http\Controllers\AgentController::getDepartmentId(3);
    return "TEST";
});



Route::get('jstemplates/{jst}',function($jst){

    if ( \Illuminate\Support\Facades\View::exists("jstemplates.$jst")  ) {
        if ( \Illuminate\Support\Facades\Auth::check()  ) {
            return view("jstemplates/$jst");
        } else {
           abort('404');
        }
    }
});

Route::get("stats-run","StatsController@run");
Route::get("stats","StatsController@index");
Route::get("login",array("uses" => "LoginController@login"))->name('login');
Route::post("login",array("uses" => "LoginController@doLogin"));
Route::get('logout', array("uses" => "LoginController@logout"))->name('logout');

Route::get('/', "HomeController@home")->name('home')->middleware('auth');
Route::get('/settings',"SettingsController@index")->name('settings')->middleware('auth');
Route::get('wa/{action}', "WAController@index")->middleware('auth');
Route::post('wa/{action}', "WAController@index")->middleware('auth');




