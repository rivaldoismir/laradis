<?php

use App\Models\Article;
// use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Cache;
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

// Implementation Cache Laravel Dengan Redis
// function remember($key, $second, $callback)
// {

//     // proses pencarian data
//     if ($value = Redis::get($key)) {
//         return json_decode($value);
//     }

//     $value = Article::all();

//     Redis::setex($key, $second, $value = $callback()); //akan muncul data selama x detik

//     return $value;
// }


Route::get('/', function () {
    // return remember('article.all', 60 * 60, function () {
    //     dd('query'); // pengecekan 
    //     return Article::all();
    // });

    return Cache::remember('article.all', 60 * 60, function () {
        dd('querry');
        return Article::all();
    });
});


// PR [Belajar seeder faker, redisstore]
// [END] Implementation Cache Laravel Dengan Redis