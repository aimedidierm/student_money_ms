<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuardianController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'index')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerSchools']);
Route::post('/register', [GuardianController::class, 'store']);
Route::get('logout', [AuthController::class, 'logout']);

Route::group(["prefix" => "admin", "middleware" => ["auth", "isAdmin"], "as" => "admin."], function () {
    Route::view('/', 'admin.blank');
    Route::view('/canteen', 'admin.blank');
    Route::view('/students', 'admin.blank');
    Route::view('/parents', 'admin.blank');
    Route::view('/transactions', 'admin.blank');
    Route::view('/settings', 'admin.blank');
});

Route::group(["prefix" => "school", "middleware" => ["auth:school", "isSchool"], "as" => "school."], function () {
    Route::view('/', 'school.blank');
    Route::view('/parents', 'school.blank');
    Route::view('/canteen', 'school.blank');
    Route::view('/withdraw', 'school.blank');
    Route::view('/transactions', 'school.blank');
    Route::view('/settings', 'school.blank');
});

Route::group(["prefix" => "canteen", "middleware" => ["auth:canteen", "isCanteen"], "as" => "canteen."], function () {
    Route::view('/', 'canteen.blank');
    Route::view('/withdraw', 'canteen.blank');
    Route::view('/transactions', 'canteen.blank');
    Route::view('/settings', 'canteen.blank');
});

Route::group(["prefix" => "parent", "middleware" => ["auth:parent", "isGuardian"], "as" => "canteen."], function () {
    Route::view('/', 'parent.blank');
    Route::view('/send', 'parent.blank');
    Route::view('/student', 'parent.blank');
    Route::view('/settings', 'parent.blank');
});
