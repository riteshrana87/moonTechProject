<?php

use Illuminate\Support\Facades\Route;


use App\Http\Livewire\Select2Dropdown;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/send-request', [App\Http\Controllers\HomeController::class, 'AddFriendRequest'])->name('send-request');
Route::get('/approved-request/{id}', [App\Http\Controllers\HomeController::class, 'approvedRequest'])->name('approved-request');
Route::get('/delete-request/{id}', [App\Http\Controllers\HomeController::class, 'deleteFriends'])->name('delete-request');





