<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PaytollController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\superAdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('roles', RoleController::class);

// Routes for cars
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{id}', [CarController::class, 'edit'])->name('cars.edit');
Route::get('/cars/create/list', [CarController::class, 'create'])->name('cars.created');
Route::post('/cars/store', [CarController::class, 'store'])->name('cars.store');
Route::delete('/cars/{car}', [CarController::class, 'delete'])->name('cars.destroy');
Route::put('/cars/update/{car}', [CarController::class, 'update'])->name('cars.update');


// Routes for drivers
Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
Route::get('/drivers/create/list', [DriverController::class, 'create'])->name('drivers.created');
Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
Route::get('/drivers/{id}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
Route::delete('/drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');
Route::get('/assign/{id}',[DriverController::class,'assigndriver'])->name('assign.driver');
Route::get('/assign/car/{car}{driver}',[DriverController::class,'assignCar'])->name('assign.car');
Route::get('unassign/{driver}',[DriverController::class,'unassign'])->name('unassign.car');
Route::get('/driver/toll/{id}',[DriverController::class, 'driverToll'])->name('driver.toll');
Route::get('/driver/charge/{id}',[DriverController::class,'driverCharge'])->name('driver.charge');
Route::get('/driver/ticket/{id}',[DriverController::class,'driverTicket'])->name('driver.ticket');



//Pay Toll Routes
Route::get('/toll', [PaytollController::class, 'index'])->name('toll');
Route::get('/pay/{id}', [PaytollController::class, 'paytoll'])->name('toll.pay');
Route::get('toll/create',[PaytollController::class, 'createToll'])->name('toll.create');
Route::post('/toll/store',[PaytollController::class,'storeToll'])->name('toll.store');
Route::get('/toll/edit/{id}',[PaytollController::class, 'editToll'])->name('toll.edit');
Route::put('/toll/update/{id}',[PaytollController::class, 'updateToll'])->name('toll.update');
Route::delete('/toll/{id}',[PaytollController::class, 'delete'])->name('toll.destroy');


//Tickets
Route::get('/tickets',[TicketController::class,'index'])->name('tickets');
Route::get('/ticket/pay/{id}',[TicketController::class, 'payticket'])->name('ticket.pay');

//City Charges
Route::get('/charges', [TicketController::class, 'city'])->name('city');
Route::get('/charges/pay/{id}',[TicketController::class, 'paycharges'])->name('charges.pay');
Route::get('/charges/create',[TicketController::class,'cityCreate'])->name('charges.create');
Route::post('/charges/store',[TicketController::class,'cityStore'])->name('charges.store');
Route::delete('/charges/delete/{id}',[TicketController::class, 'cityDelete'])->name('charges.destroy');
Route::get('/city.charges/{id}',[TicketController::class, 'cityEdit'])->name('charges.edit');
Route::put('/charges/update/{id}',[TicketController::class,'cityUpdate'])->name('charges.update');

//Stripe payment
Route::post('/payment/{id}',[TicketController::class, 'stripe'])->name('payment');
Route::get('/bulk',[TicketController::class, 'selectMultiple'])->name('bulk');
Route::post('/bulkpayment',[TicketController::class, 'bulkStripe'])->name('bulkStripe');

// Card Enter

Route::post('/card',[PaytollController::class, 'card'])->name('card');
Route::delete('/card/{id}', [PaytollController::class, 'cardDelete'])->name('card.delete');


//-------------------------------------Super Admin Routes---------------------------------------------------


// Routes for Users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::delete('/users{user}', [UserController::class, 'delete'])->name('users.destroy');
Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/settings/{id}',[UserController::class, 'setting'])->name('settings');

// Routes for all tickets

Route::get('/all-tickets', [superAdminController::class, 'totalTickets'])->name('admin.tickets');
Route::get('admin/{id}/{name}/{d_id}', [superAdminController::class, 'adminPay'])->name('admin.pay');
Route::get('/marked-pay', [superAdminController::class, 'markedPay'])->name('marked.pay');
Route::get('/user-details/{id}', [superAdminController::class, 'adminData'])->name('admin.details');


