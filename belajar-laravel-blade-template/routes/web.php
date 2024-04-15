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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', [
        'name' => 'ade',
    ]);
});

Route::get('/world', function () {
    return view('hello.world', [
        'name' => 'ade',
    ]);
});

Route::get('/html-encoding', function (\Illuminate\Http\Request $request) {
   return view('html-encoding', ["name" => $request->input('name')]);
});

Route::get('/test', function () {
    return \Illuminate\Support\Facades\Blade::render('hello {{$name}}', [
        'name' => 'ade'
    ]);
});

Route::get('/test1', function () {
    return \Illuminate\Support\Facades\Blade::render('hello', [
        'name' => 'ade'
    ]);
});
