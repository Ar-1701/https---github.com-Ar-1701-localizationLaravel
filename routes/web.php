<?php

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Language;
use App\Models\Post;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::group(['prefix' => App::setLocale(), 'controller' => 'LocalizationController'], function () {
//     Route::get('/', 'index');
// });
Route::controller(LocalizationController::class)->group(function () {
    Route::middleware(['middleware' => 'localMiddle'])->group(function () {
        Route::get("/", "index");
        Route::get("add_post", "add_post");
        Route::post('langs', 'lang');
        Route::get('show_post', 'show_post')->name('show_post');
        Route::get('posts', 'posts')->name('posts');
        Route::post('save_post', 'save_post');
    });
});
// Route::get('/{locale}', function ($locale) {
//     App::setLocale($locale);
//     $l = Language::where('lang', App::getLocale())->first();
//     $data['lang'] = Language::all();
//     $data['post'] = Post::whereRaw('lang_id=?', $l->id)->get();
//     Session::put('lang', $l->lang);
//     Session::put('langId', $l->id);
//     return view('show', $data);
//     // return view('show');
// });
