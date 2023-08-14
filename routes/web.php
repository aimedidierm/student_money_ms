<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
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
    // Route::resource('/', SchoolController::class)->only('index', 'store');
    Route::post('/school/{school}', [SchoolController::class, 'update']);
    Route::get('/school/{school}', [SchoolController::class, 'destroy']);
    Route::get('/canteen', [CanteenController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/parents', [GuardianController::class, 'index']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::resource('/settings', UserController::class)->only('index', 'update');
});

Route::group(["prefix" => "school", "middleware" => ["auth:school", "isSchool"], "as" => "school."], function () {
    Route::get('/', [StudentController::class, 'create']);
    Route::post('/', [StudentController::class, 'store']);
    Route::post('/students/{student}', [StudentController::class, 'update']);
    Route::get('/students/{student}', [StudentController::class, 'destroy']);
    Route::get('/parents', [GuardianController::class, 'create']);
    Route::post('/parents/update', [GuardianController::class, 'update']);
    Route::get('/canteen', [CanteenController::class, 'schoolList']);
    Route::put('/canteen', [CanteenController::class, 'update']);
    Route::resource('/canteen', CanteenController::class)->only('store', 'destroy');
    Route::resource('/withdraw', WithdrawController::class)->only('index', 'store');
    Route::get('/transactions', [TransactionController::class, 'create']);
    Route::get('/settings', [SchoolController::class, 'create']);
    Route::put('/settings', [SchoolController::class, 'updateProfile']);
});

Route::group(["prefix" => "canteen", "middleware" => ["auth:canteen", "isCanteen"], "as" => "canteen."], function () {
    Route::view('/', 'canteen.purchase');
    Route::post('/buy', [TransactionController::class, 'canteenPurchaseView']);
    Route::get('/withdraw', [WithdrawController::class, 'create']);
    Route::post('/withdraw', [WithdrawController::class, 'canteenWithdraw']);
    Route::get('/transactions', [TransactionController::class, 'canteenList']);
    Route::get('/settings', [CanteenController::class, 'create']);
    Route::put('/settings', [CanteenController::class, 'updateProfile']);
});

Route::group(["prefix" => "parent", "middleware" => ["auth:parent", "isGuardian"], "as" => "canteen."], function () {
    Route::get('/', [StudentController::class, 'sendMoney']);
    Route::post('/student', [LimitController::class, 'store']);
    Route::post('/send', [StudentController::class, 'sendMoneyToStudent']);
    Route::get('/student', [LimitController::class, 'index']);
    Route::get('/settings', [GuardianController::class, 'parentShow']);
    Route::put('/settings', [GuardianController::class, 'updateProfile']);
});
