<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\availabletimescontroller;
use App\Http\Controllers\complexescontroller;
use App\Http\Controllers\paymentscontroller;
use App\Http\Controllers\rolescontroller;
use App\Http\Controllers\salonreservescontroller;
use App\Http\Controllers\salonscontroller;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/complexes', function () {
    return view('complexes');
})->middleware(['auth', 'verified'])->name('complexes');

Route::get('/my_complexes', function () {
    return view('my_complexes');
})->middleware(['auth', 'verified'])->name('my_complexes');

Route::get('/my_complexes_admins', function () {
    return view('my_complexes_admins');
})->middleware(['auth', 'verified'])->name('my_complexes_admins');

Route::get('/complexes_verify', function () {
    return view('complexes_verify');
})->middleware(['auth', 'verified'])->name('complexes_verify');

Route::get('/complex', function () {
    return view('complex');
})->middleware(['auth', 'verified'])->name('complex');

Route::get('/salon', function () {
    return view('salon');
})->middleware(['auth', 'verified'])->name('salon');

Route::get('/my_salon_reserves', function () {
    return view('my_salon_reserves');
})->middleware(['auth', 'verified'])->name('my_salon_reserves');

Route::get('/salon_avaible_times', function () {
    return view('salon_avaible_times');
})->middleware(['auth', 'verified'])->name('salon_avaible_times');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/add_complex', [complexescontroller::class, 'add_complex'])->name('add_complex');
Route::post('/delete_complex', [complexescontroller::class, 'delete_complex'])->name('delete_complex');
Route::get('/get_complexes', [complexescontroller::class, 'get_complexes'])->name('get_complexes');
Route::get('/get_my_complexes', [complexescontroller::class, 'get_my_complexes'])->name('get_my_complexes');
Route::get('/get_all_complexes', [complexescontroller::class, 'get_all_complexes'])->name('get_all_complexes');
Route::post('/update_verify', [complexescontroller::class, 'update_verify'])->name('update_verify');

Route::post('/add_salon', [salonscontroller::class, 'add_salon'])->name('add_salon');
Route::post('/delete_salon', [salonscontroller::class, 'delete_salon'])->name('delete_salon');
Route::get('/get_salons', [salonscontroller::class, 'get_salons'])->name('get_salons');
Route::get('/get_my_salons', [salonscontroller::class, 'get_my_salons'])->name('get_my_salons');

Route::post('/add_available_time', [availabletimescontroller::class, 'add_available_time'])->name('add_available_time');
Route::post('/delete_available_time', [availabletimescontroller::class, 'delete_available_time'])->name('delete_available_time');
Route::get('/get_available_times', [availabletimescontroller::class, 'get_available_times'])->name('get_available_times');
Route::get('/get_available_times_day_of_week', [availabletimescontroller::class, 'get_available_times_day_of_week'])->name('get_available_times_day_of_week');

Route::post('/add_payment', [paymentscontroller::class, 'add_payment'])->name('add_payment');
Route::post('/delete_payment', [paymentscontroller::class, 'delete_payment'])->name('delete_payment');
Route::get('/get_payments', [paymentscontroller::class, 'get_payments'])->name('get_payments');

Route::post('/add_role', [rolescontroller::class, 'add_role'])->name('add_role');
Route::post('/delete_role', [rolescontroller::class, 'delete_role'])->name('delete_role');
Route::get('/get_roles', [rolescontroller::class, 'get_roles'])->name('get_roles');

Route::post('/add_salon_reserve', [salonreservescontroller::class, 'add_salon_reserve'])->name('add_salon_reserve');
Route::post('/delete_salon_reserve', [salonreservescontroller::class, 'delete_salon_reserve'])->name('delete_salon_reserve');
Route::get('/get_salon_reserves_salon_id', [salonreservescontroller::class, 'get_salon_reserves_salon_id'])->name('get_salon_reserves_salon_id');
Route::get('/get_salon_reserves_user_id', [salonreservescontroller::class, 'get_salon_reserves_user_id'])->name('get_salon_reserves_user_id');


require __DIR__.'/auth.php';
