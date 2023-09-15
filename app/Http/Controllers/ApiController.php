<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Driver;
use App\Models\Paytoll;
use App\Models\Ticket;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('number', 'password');
        $driver = Driver::where('number', $credentials['number'])->whereNotNull('car_id')->first();

        if ($driver && Hash::check($credentials['password'], $driver->password)) {
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'user' => $driver,
                'car' => $driver->car->number,

            ],200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Login failed'
        ], 200);
    }
    public function allCharges(Request $request)
    {

        $city = City::all();
        if ($city->count() > 0) {

            return response()->json([
                'status' => true,
                'message' => 'City Charges',
                'charges' => $city,
            ], 200);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'No City charges to show',
            ]);
        }
    }
    public function driverCharge(Request $request)
    {
        $cityId = $request->input('city_id');
        $driverId = $request->input('driver_id');
        $notes = $request->input('notes');

        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ]);
        }
        DB::table('city_driver')->insert([
            'city_id' => $cityId,
            'driver_id' => $driverId,
            'notes' => $notes,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'IDs stored successfully'], 200);
    }


    public function allToll()
    {
        $toll = Paytoll::all();
        if ($toll->count() > 0) {
            return response()->json([
                'status' => true,
                'message' => 'Tolls',
                'tolls' => $toll,
            ], 200);
        } else {
            return response()->json([
                'message' => 'No toll found',
                'status' => false,
            ],200);
        }
    }

    public function driverToll(Request $request)
    {
        $tollId = $request->input('paytoll_id');
        $driverId = $request->input('driver_id');
        $notes = $request->input('notes');

        $validator = Validator::make($request->all(), [
            'paytoll_id' => 'required|exists:paytolls,id',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => false

            ]);
        }
        DB::table('driver_paytoll')->insert([
            'paytoll_id' => $tollId,
            'driver_id' => $driverId,
            'notes' => $notes,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'IDs stored successfully'], 200);
    }
    public function ticket(Request $request)
    {
        try {
            $validateData = $request->validate([
                'pcn' => 'required',
                'date' => 'required',
                'price' => 'required',
                'ticket_issuer' => 'required',
                'driver_id' => 'required|exists:drivers,id',

            ]);
            Ticket::create($validateData);
            return response()->json([
                'mesage' => 'ticket is stored',
                'status' => true,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'ticket data is not stored',
                'status' => false

            ]);
        }
    }

    public function driverTicket(Request $request)
    {
        $id = $request->input('driver_id');
        $tickets = Ticket::where('driver_id', $id)->get();
        if ($tickets->isEmpty()) {
            return response()->json([
                'message' => 'No tickets found for this driver',
                'status' => false,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tickets found',
                'tickets' => $tickets], 200);
        }
    }
}
