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

Route::get('/ade', function () {
    return "Hello Ade Nafil Firmansah";
});

Route::redirect('/youtube', 'ade');

Route::fallback(function () {
    return "404 by ade";
});

Route::view('/hello', 'hello', ['name' => 'ade']);

Route::get('/hello-again', function () {
    return view("hello", ['name' => 'nafil']);
});

Route::get('/hello-world', function () {
    return view("hello.world", ['name' => 'nafil']);
});

Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
});

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, item $itemId";
});

Route::get('/categories/{id}', function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+');

Route::get('/users/{id?}', function ($userId = "not found") {
   return "User $userId";
});

Route::get('/conflict/ade', function () {
    return "Conflict ade nafil firmansah";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});
