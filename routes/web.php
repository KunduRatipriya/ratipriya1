<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Record;
use App\Http\Controllers\AdminController;

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
Route::prefix('admin')->group(function () {
    //Register
    Route::get('auth/register', [AdminController::class, 'showRegister'])->name('register');
    Route::post('auth/register', [AdminController::class, 'register'])->name('registration');
    //Login
    Route::get('auth/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('auth/loginStore',[AdminController::class, 'storeLogin'])->name('storeLogin');
    //User Display 
    Route::get('auth/users', [AdminController::class, 'showUser'])->name('users');
    //User Add
    Route::post('auth/addUser', [AdminController::class, 'addUser'])->name('addUser');
    //Delete User
    Route::post('auth/deleteUser', [AdminController::class, 'deleteUser'])->name('deleteUser');
    //Update User
    Route::post('auth/updateUser', [AdminController::class, 'updateUser'])->name('updateUser');
});
