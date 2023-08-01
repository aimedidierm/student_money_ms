<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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
    Route::resource('/', SchoolController::class)->only('index', 'store');
    Route::post('/school/{school}', [SchoolController::class, 'update']);
    Route::get('/school/{school}', [SchoolController::class, 'destroy']);
    Route::get('/canteen', [CanteenController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/parents', [GuardianController::class, 'index']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::resource('/settings', UserController::class)->only('index', 'update');
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
