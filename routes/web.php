<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ApartmentsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ReportsController;

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

Route::get('/', [IndexController::class,'index'])->name('index')->middleware('auth');
Route::get('/login', [IndexController::class,'login'])->name('index.login');
Route::get('/logout', [IndexController::class,'logout'])->name('index.logout');
Route::post('/auth', [IndexController::class,'auth'])->name('index.auth');
Route::get('/github', [IndexController::class,'github'])->name('index.github');
Route::get('/oauth', [IndexController::class,'oauth'])->name('index.oauth');
Route::get('/signup', [IndexController::class,'signup'])->name('index.signup');
Route::post('/signup', [IndexController::class,'signup'])->name('index.signup');
Route::get('/users', [UsersController::class,'index'])->name('users.index')->middleware('auth');
Route::get('/users/add', [UsersController::class,'add'])->name('users.add')->middleware('auth');
Route::post('/users/add', [UsersController::class,'add'])->name('users.add.save')->middleware('auth');
Route::get('/users/change/{id}', [UsersController::class,'change'])->name('users.change')->middleware('auth');
Route::post('/users/change/{id}', [UsersController::class,'change'])->name('users.change.save')->middleware('auth');
Route::get('/users/delete/{id}', [UsersController::class,'delete'])->name('users.delete')->middleware('auth');
Route::get('/clients', [ClientsController::class,'index'])->name('clients.index')->middleware('auth');
Route::get('/clients/add', [ClientsController::class,'add'])->name('clients.add')->middleware('auth');
Route::post('/clients/add', [ClientsController::class,'add'])->name('clients.add.save')->middleware('auth');
Route::get('/clients/change/{id}', [ClientsController::class,'change'])->name('clients.change')->middleware('auth');
Route::post('/clients/change/{id}', [ClientsController::class,'change'])->name('clients.change.save')->middleware('auth');
Route::get('/clients/delete/{id}', [ClientsController::class,'delete'])->name('clients.delete')->middleware('auth');
Route::get('/clients/export', [ClientsController::class,'export'])->name('clients.export')->middleware('auth');
Route::get('/apartments', [ApartmentsController::class,'index'])->name('apartments.index')->middleware('auth');
Route::get('/apartments/add', [ApartmentsController::class,'add'])->name('apartments.add')->middleware('auth');
Route::post('/apartments/add', [ApartmentsController::class,'add'])->name('apartments.add.save')->middleware('auth');
Route::get('/apartments/change/{id}', [ApartmentsController::class,'change'])->name('apartments.change')->middleware('auth');
Route::post('/apartments/change/{id}', [ApartmentsController::class,'change'])->name('apartments.change.save')->middleware('auth');
Route::get('/apartments/delete/{id}', [ApartmentsController::class,'delete'])->name('apartments.delete')->middleware('auth');
Route::get('/plans', [PlansController::class,'index'])->name('plans.index')->middleware('auth');
Route::get('/plans/add', [PlansController::class,'add'])->name('plans.add')->middleware('auth');
Route::post('/plans/add', [PlansController::class,'add'])->name('plans.add.save')->middleware('auth');
Route::get('/plans/change/{id}', [PlansController::class,'change'])->name('plans.change')->middleware('auth');
Route::post('/plans/change/{id}', [PlansController::class,'change'])->name('plans.change.save')->middleware('auth');
Route::get('/plans/delete/{id}', [PlansController::class,'delete'])->name('plans.delete')->middleware('auth');
Route::get('/services', [ServicesController::class,'index'])->name('services.index')->middleware('auth');
Route::get('/services/add', [ServicesController::class,'add'])->name('services.add')->middleware('auth');
Route::post('/services/add', [ServicesController::class,'add'])->name('services.add.save')->middleware('auth');
Route::get('/services/change/{id}', [ServicesController::class,'change'])->name('services.change')->middleware('auth');
Route::post('/services/change/{id}', [ServicesController::class,'change'])->name('services.change.save')->middleware('auth');
Route::get('/services/delete/{id}', [ServicesController::class,'delete'])->name('services.delete')->middleware('auth');
Route::get('/register', [IndexController::class,'register'])->name('index.register');
Route::post('/register', [IndexController::class,'register'])->name('index.register.save');
Route::get('/get-services/{id}', [IndexController::class,'services'])->name('index.services')->middleware('auth');
Route::post('/add-service', [IndexController::class,'addservice'])->name('index.add.service')->middleware('auth');
Route::get('/delete-service', [IndexController::class,'deleteservice'])->name('index.delete.service')->middleware('auth');
Route::get('/release/{id}', [IndexController::class,'release'])->name('index.release')->middleware('auth');
Route::get('/reports', [ReportsController::class,'index'])->name('reports.index')->middleware('auth');
Route::get('/reports/export', [ReportsController::class,'export'])->name('reports.export')->middleware('auth');