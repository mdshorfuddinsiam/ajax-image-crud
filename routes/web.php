<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee/add', [EmployeeController::class, 'store']);
Route::get('/employee/all', [EmployeeController::class, 'showEmployee']);
Route::post('/employee/edit/{id}', [EmployeeController::class, 'editEmployee']);
Route::post('/employee/update', [EmployeeController::class, 'updateEmployee']);
Route::post('/employee/delete/{id}', [EmployeeController::class, 'deleteEmployee']);
