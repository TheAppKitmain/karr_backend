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
Route::controller(CarController::class)->group(function () {
    Route::get('/cars', 'index')->name('cars.index');
    Route::get('/cars/{id}', 'edit')->name('cars.edit');
    Route::get('/cars/create/list', 'create')->name('cars.created');
    Route::post('/cars/store', 'store')->name('cars.store');
    Route::delete('/cars/{car}', 'delete')->name('cars.destroy');
    Route::put('/cars/update/{car}', 'update')->name('cars.update');
});



// Routes for drivers
Route::controller(DriverController::class)->group(function () {
    Route::get('/drivers', 'index')->name('drivers.index');
    Route::get('/drivers/create/list', 'create')->name('drivers.created');
    Route::post('/drivers', 'store')->name('drivers.store');
    Route::get('/drivers/{id}/edit', 'edit')->name('drivers.edit');
    Route::put('/drivers/{driver}', 'update')->name('drivers.update');
    Route::delete('/drivers/{driver}', 'destroy')->name('drivers.destroy');
    Route::get('/assign/{id}', 'assigndriver')->name('assign.driver');
    Route::get('/assign/car/{car}{driver}', 'assignCar')->name('assign.car');
    Route::get('unassign/{driver}', 'unassign')->name('unassign.car');
    Route::get('/driver/toll/{id}', 'driverToll')->name('driver.toll');
    Route::get('/driver/charge/{id}', 'driverCharge')->name('driver.charge');
    Route::get('/driver/ticket/{id}', 'driverTicket')->name('driver.ticket');
    Route::post('/import','import')->name('drivers.import');
    Route::get('/download','download')->name('download.template');
});



//Pay Toll Routes
Route::controller(PaytollController::class)->group(function () {
    Route::get('/toll', 'index')->name('toll');
    Route::get('/pay/{id}/{d_id}', 'paytoll')->name('toll.pay');
    Route::get('toll/create', 'createToll')->name('toll.create');
    Route::post('/toll/store', 'storeToll')->name('toll.store');
    Route::get('/toll/edit/{id}', 'editToll')->name('toll.edit');
    Route::put('/toll/update/{id}', 'updateToll')->name('toll.update');
    Route::delete('/toll/{id}', 'delete')->name('toll.destroy');
    // Card Enter
        
    Route::post('/card', 'card')->name('card');
    Route::delete('/card/{id}', 'cardDelete')->name('card.delete');
});

//Tickets
Route::controller(TicketController::class)->group(function () {
    
    Route::get('/tickets', 'index')->name('tickets');
    Route::get('/ticket/pay/{id}', 'payticket')->name('ticket.pay');
    
    //City Charges
    Route::get('/charges', 'city')->name('city');
    Route::get('/charges/pay/{id}/{d_id}', 'paycharges')->name('charges.pay');
    Route::get('/charges/create', 'cityCreate')->name('charges.create');
    Route::post('/charges/store', 'cityStore')->name('charges.store');
    Route::delete('/charges/delete/{id}', 'cityDelete')->name('charges.destroy');
    Route::get('/city.charges/{id}', 'cityEdit')->name('charges.edit');
    Route::put('/charges/update/{id}', 'cityUpdate')->name('charges.update');
    
    //Stripe payment
    Route::post('/payment/{id}', 'stripe')->name('payment');
    Route::get('/bulk', 'selectMultiple')->name('bulk');
    Route::post('/bulkpayment', 'bulkStripe')->name('bulkStripe');
});



//-------------------------------------Super Admin Routes---------------------------------------------------


// Routes for Users
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/user/create', 'create')->name('users.create');
    Route::get('/users/{user}', 'edit')->name('users.edit');
    Route::post('/users/store', 'store')->name('users.store');
    Route::delete('/users{user}', 'delete')->name('users.destroy');
    Route::put('users/update/{user}', 'update')->name('users.update');
    Route::get('/settings/{id}', 'setting')->name('settings');
    Route::get('/analytics', 'analytics')->name('users.analytics');
    Route::put('admin/update/{id}','updateUser')->name('admin.update');
});

// Routes for all tickets and tolls
Route::controller(superAdminController::class)->group(function () {
    Route::get('/all-tickets','totalTickets')->name('admin.tickets');
    Route::get('admin/{id}/{name}/{d_id}','adminPay')->name('admin.pay');
    Route::get('/marked-pay','markedPay')->name('marked.pay');
    Route::get('/user-details/{id}','adminData')->name('admin.details');
    Route::get('unpaid/{id}/{name}/{d_id}','unpaid')->name('admin.unpaid');
    Route::get('/tolls/charges', 'tollCharges')->name('admin.tolls');
    Route::get('/privacy', 'privacy');
    Route::get('/terms-conditions','termsCondition');
    Route::get('/fines','fines')->name('admin.fines');

});
