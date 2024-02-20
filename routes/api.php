<?php

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [ApiController::class,'login']);
Route::get('/city',[ApiController::class, 'allCharges']);
Route::get('/toll', [ApiController::class, 'allToll']);
Route::post('/driver/city',[ApiController::class,'driverCharge']);
Route::post('/driver/toll',[ApiController::class,'driverToll']);
Route::post('/ticket', [ApiController::class, 'ticket']);
Route::post('/driver/ticket', [ApiController::class, 'driverTicket']);
Route::post('/recent/activity',[ApiController::class, 'recentActivity']);
Route::post('/add/notes',[ApiController::class, 'addNotes']);
Route::post('/password', [ApiController::class, 'password']);
Route::post('/fines',[ApiController::class,'fineImages']);
Route::delete('/deleteTicket',[ApiController::class,'deleteTicket']);
Route::put('/updateTicket',[ApiController::class,'updateTicket']);