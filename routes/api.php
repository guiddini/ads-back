<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpacesController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ReservationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Register
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Verify email
Route::get('verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
// Resend link to verify email
Route::post('verify/resend', [AuthController::class, 'resend'])->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Forgot Password
Route::post('/password/forgot', [AuthController::class, 'forgot']);
// Reset Password
Route::post('/password/reset', [AuthController::class, 'reset']);

Route::group(['middleware'=>['auth:sanctum', 'verified']], function (){
   Route::get('/users', [UsersController::class, 'index']);
   Route::get('/users/{user}', [UsersController::class, 'show']);
   Route::patch('/users/{user}/update', [UsersController::class, 'update']);
   Route::delete('/users/{user}/delete', [UsersController::class, 'destroy']);
   // Change Password
   Route::post('users/{user}/password/change', [AuthController::class, 'change']);

   Route::get('/spaces', [SpacesController::class, 'index']);
   Route::post('/spaces/store', [SpacesController::class, 'store']);
   Route::get('/spaces/{space}', [SpacesController::class, 'show']);
   Route::patch('/spaces/{space}/update', [SpacesController::class, 'update']);
   Route::delete('/spaces/{space}/delete', [SpacesController::class, 'destroy']);

   Route::post('/spaces/{space}/reserve', [ReservationsController::class, 'store']);
   Route::get('/reservations/{reservation}', [ReservationsController::class, 'show']);
   Route::delete('/reservations/{reservation}/delete', [ReservationsController::class, 'destroy']);
});
