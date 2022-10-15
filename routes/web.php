<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ListingController;

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

//all listings
Route::get('/', [ListingController::class, 'index']);


//show create form 
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//store create form 
Route::post('/listings', [ListingController::class, 'store']);

//show edit form 
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//update submit
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//delete submit
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//single listing
Route::get('/listings/{id}', [ListingController::class, 'show']);

//show register
Route::get('/register', [userController::class, 'create'])->middleware('guest');

//create New user
Route::post('/users', [userController::class, 'store']);

//log user out
Route::post('/logout', [userController::class, 'logout'])->middleware('auth');

//show login form
Route::get('/login', [userController::class, 'login'])->name('login')->middleware('guest');

// login user
Route::post('/users/authenticate', [userController::class, 'authenticate']);