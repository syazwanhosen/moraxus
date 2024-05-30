<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;

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

Route::get('{any?}', function() {
    return view('application');
})->where('any', '.*');

// Route to display the registration form
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Route to handle the registration process
Route::post('/register', [AuthController::class, 'register']);

// Route to display the login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route to handle the login process
Route::post('/login', [AuthController::class, 'login']);


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');






