<?php

use App\Models\Blog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SubscriberController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/app', function(){
    return view('welcome');
});


// custom way laravel localization
// Route::controller(ThemeController::class)->prefix('{locale}')->name('theme.')->middleware('setLocale')->group(function (){
//     // dd(request()->segment(1));
//     Route::get('/', 'index')->name('index');
//     Route::get('/category/{category}', 'category')->name('category');
//     Route::get('/contact', 'contact')->name('contact');
// })->where('locale', '[a-z](2)');

// package mcamara laravel localization
Route::controller(ThemeController::class)->name('theme.')->group(function (){

    Route::get('/', 'index')->name('index');
    Route::get('/category/{category}', 'category')->name('category');
    Route::get('/contact', 'contact')->name('contact');
});

// subscribers
Route::post('/subscriber/store', [SubscriberController::class, 'store'])->name('subscriber.store');

// contacts
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');

// blogs

Route::get('/my-blogs', [BlogController::class, 'myBlogs'])->name('blogs.my-blogs')->middleware('customVerified');
    // Route::resource('blogs', BlogController::class)->except('index')->parameters(['blogs' => 'blog:slug']);
Route::resource('blogs', BlogController::class)->except('index')->middleware('customVerified');    



// commemts
Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::prefix('google')->name('google.')->controller(SocialiteController::class)->group(function (){
    Route::get('/login', 'login')->name('login');
    Route::get('/redirect', 'redirect')->name('redirect');
});
