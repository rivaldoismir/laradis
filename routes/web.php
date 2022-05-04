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


// =========== Implementasi Sorted Sets Di Laravel =================
Route::get('/topic/{topic}', function ($topic) {
    return $topic;
});

Route::get('/topic/{topic}/visit', function ($topic) {
    Redis::zincrby('trending', 1, $topic);
    Redis::zremrangebyrank('trending', 0, -4); // untuk menghapus atau cuma menampilkan 3 terbesar saja
    return redirect()->back();
});

Route::get('/trending', function () {
    // $trending = Redis::zrange('trending', 0, -1);
    $trending = Redis::zrevrange('trending', 0, -1);
    return $trending;
});


// C:\Users\LENOVO>redis-cli
// 127.0.0.1:6379> keys *
// 1) "number"
// 2) "laravel_database_trending"
// 3) "laravel_database_article.11.views"
// 4) "trending_article"
// 5) "framework"
// 6) "user:1"
// 7) "laravel_database_world"
// 8) "laravel_database_article.1.views"
// 127.0.0.1:6379> zrange laravel_database_trending 0 -1
// 1) "laravel"
// 127.0.0.1:6379>
// 127.0.0.1:6379> keys *
// 1) "number"
// 2) "laravel_database_trending"
// 3) "laravel_database_article.11.views"
// 4) "trending_article"
// 5) "framework"
// 6) "user:1"
// 7) "laravel_database_world"
// 8) "laravel_database_article.1.views"
// 127.0.0.1:6379> zrange laravel_database_trending 0 -1
// 1) "laravel"
// 127.0.0.1:6379> zrange laravel_database_trending 0 -1
// 1) "laravel"
// 2) "php"
// 127.0.0.1:6379> zrange laravel_database_trending 0 -1 WITHSCORES
// 1) "laravel"
// 2) "1"
// 3) "php"
// 4) "3"
// [END] =========== Implementasi Sorted Sets Di Laravel =================


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