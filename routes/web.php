<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;


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

Route::get('/', function () {
    return view('welcome');
});

// Socialite login.
Route::get('social-redirect/{social_type}', [LoginController::class, 'socialiteRedirect'])->whereIn('social_type', ['github','google','facebook', 'twitter']);

Route::get('social-back/{social_type}', [LoginController::class, 'socialiteLogin'])->whereIn('social_type', ['github','google','facebook', 'twitter']);
