<?php

use Illuminate\Support\Facades\Redis;
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

Route::get('/', function () {
    // Redis::set('world', 'hello');
    // return Redis::get('world');

    return view('welcome');
});


Route::get('/article/{id}', function ($id) {
    $views = Redis::get("article.{$id}.views");
    return "Article dengan id {$id} memiliki {$views} viewer";
});

Route::get('/article/{id}/visit', function ($id) {
    $views = Redis::incr("article.{$id}.views");
    return redirect()->back();
});


// more command in https://redis.io/commands/
// 127.0.0.1:6379> ZA
// (integer) 1       
// 127.0.0.1:6379> ZA
// (integer) 1       
// 127.0.0.1:6379> ZR
// 1) "belajar-larave
// 2) "belajar-php"  
// 127.0.0.1:6379> ZR
// 1) "belajar-larave
// 2) "1"            
// 3) "belajar-php"  
// 4) "1"            
// 127.0.0.1:6379> ZI
// "11"              
// 127.0.0.1:6379> ZR
// 1) "belajar-php"  
// 2) "1"            
// 3) "belajar-larave
// 4) "11"           
// 127.0.0.1:6379> ZR
// 1) "belajar-larave
// 2) "11"           
// 3) "belajar-php"  
// 4) "1"            
// 127.0.0.1:6379> ZC
// (integer) 2       