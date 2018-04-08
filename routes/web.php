<?php

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


Route::get('/',"StaticPagesController@home")->name('home');
Route::get("/help","StaticPagesController@help")->name('help');
Route::get("/about","StaticPagesController@about")->name("about");
// Route::get("/help",["as"=>"help",'uses'=>"StaticPagesController@help"]);
// Route::match(array('get','post'), "/","StaticPagesController@home")->name("home");
Route::get("signup","UsersController@create")->name("signup");
Route::resource("users", "UsersController");//自动创建路由

/*
 * 登录
 */
Route::get("login","SessionsController@create")->name("login");
Route::post("login","SessionsController@store")->name("login");
Route::delete("logout","SessionsController@destroy")->name("logout");
Route::post("logout","SessionsController@destroy")->name("logout");
Route::get("admin_login","SessionsController@login")->name("admin_login");
Route::post("admin_login","SessionsController@dologin")->name("admin_login");
Route::post("admin_logout","SessionsController@admin_logout")->name("admin_logout");