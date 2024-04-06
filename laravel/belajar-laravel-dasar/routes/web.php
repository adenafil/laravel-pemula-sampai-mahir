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
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, item $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = "not found") {
   return "User $userId";
})->name('user.detail');

Route::get('/conflict/ade', function () {
    return "Conflict ade nafil firmansah";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', [
        'id' => $id
    ]);
});

Route::get('/controller/hello/request', [\App\Http\Controllers\HelloController::class, 'request']);

Route::get('/controller/hello/{name}', [\App\Http\Controllers\HelloController::class, 'hello']);

Route::get('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello/first', [\App\Http\Controllers\InputController::class, 'helloFirstName']);
Route::post('/input/hello/input', [\App\Http\Controllers\InputController::class, 'helloInput']);
Route::post('/input/hello/array', [\App\Http\Controllers\InputController::class, 'helloArray']);
Route::post('/input/type', [\App\Http\Controllers\InputController::class, 'inputType']);
Route::post('/input/filter/only', [\App\Http\Controllers\InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [\App\Http\Controllers\InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [\App\Http\Controllers\InputController::class, 'filterMerge']);

Route::post('/file/upload', [\App\Http\Controllers\FileController::class, 'upload'])
->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/response/hello', [\App\Http\Controllers\ResponseController::class, 'response']);
Route::get('/response/header', [\App\Http\Controllers\ResponseController::class, 'header']);

Route::prefix('/response/type')->controller(\App\Http\Controllers\ResponseController::class)->group(function () {
    Route::get('/view',  'responseView');
    Route::get('/json', 'responseJson');
    Route::get('/file', 'responseFile');
    Route::get('/download', 'responseDownload');
});

Route::controller(\App\Http\Controllers\CookieController::class)->group(function () {
   Route::prefix('/cookie')->group(function () {
       Route::get('/set','createCookie');
       Route::get('/get','getCookie');
       Route::get('/clear', 'clearCookie');
   }) ;
});

Route::get('/redirect/from' , [\App\Http\Controllers\RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to' , [\App\Http\Controllers\RedirectController::class, 'redirectTo']);
Route::get('/redirect/name' , [\App\Http\Controllers\RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}' , [\App\Http\Controllers\RedirectController::class, 'redirectHello'])
    ->name("redirect-hello");

Route::get('/redirect/named', function () {
   return \Illuminate\Support\Facades\URL::route('redirect-hello', [
       'name' => 'ade'
   ]);
});

Route::get('/redirect/action' , [\App\Http\Controllers\RedirectController::class, 'redirectAction']);
Route::get('/redirect/away' , [\App\Http\Controllers\RedirectController::class, 'redirectAway']);

Route::middleware(['contoh:PZN, 401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () {
        return "OK";
    });
    Route::get('/group', function () {
        return "GROUP";
    });
});

Route::get('/form', [\App\Http\Controllers\FormController::class, 'form']);

Route::get('/url/action', function () {
//    return action([\App\Http\Controllers\FormController::class, 'form']);
//    return url()->action([\App\Http\Controllers\FormController::class, 'form']);
    return \Illuminate\Support\Facades\URL::action([\App\Http\Controllers\FormController::class, 'form']);
});

Route::post('/form', [\App\Http\Controllers\FormController::class, 'submitForm']);

Route::get('/url/current', function () {
    return \Illuminate\Support\Facades\URL::full();
});
