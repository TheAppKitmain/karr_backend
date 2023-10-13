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
        $credentials = $request->only('number', 'password', 'email');
        $driver = Driver::where('email', $credentials['email'])->first();

        if ($driver && Hash::check($credentials['password'], $driver->password) && $driver->number === $credentials['number']) {
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'user' => $driver,
            ], 200);
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
        $cityids = $request->input('city_id');
        $driverId = $request->input('driver_id');
        $date = $request->input('date');
        $notes = $request->input('notes');

        $validator = Validator::make($request->all(), [
            'city_id' => 'required|array',
            'city_id.*' => 'required|exists:cities,id',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ]);
        }
        foreach ($cityids as $cityId) {
            $existingData = DB::table('city__drivers')
                ->where('city_id', $cityId)
                ->where('driver_id', $driverId)
                ->first();

            if ($existingData) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data already exists for the provided IDs'
                ], 200);
            }
            DB::table('city__drivers')->insert([
                'city_id' => $cityId,
                'driver_id' => $driverId,
                'date' => $date,
                'notes' => $notes,
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'IDs stored successfully'
        ], 200);
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
            ], 200);
        }
    }

    public function driverToll(Request $request)
    {
        $tollIds = $request->input('paytoll_id'); // Assuming the input field is named 'paytoll_ids' as an array.
        $driverId = $request->input('driver_id');
        $date = $request->input('date');
        $way = $request->input('way');
        $notes = $request->input('notes');

        $validator = Validator::make($request->all(), [
            'paytoll_id' => 'required|array',
            'paytoll_id.*' => 'required|exists:paytolls,id', // Validate each 'paytoll_id' in the array.
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        foreach ($tollIds as $tollId) {
            $existingData = DB::table('paytoll__drivers')
                ->where('paytoll_id', $tollId)
                ->where('driver_id', $driverId)
                ->first();

            if ($existingData) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data already exists for the provided IDs'
                ], 200);
            }

            // Insert the record for the current 'paytoll_id' and 'driverId'.
            DB::table('paytoll__drivers')->insert([
                'paytoll_id' => $tollId,
                'driver_id' => $driverId,
                'way' => $way,
                'date' => $date,
                'notes' => $notes,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'IDs stored successfully'
        ], 200);
    }

    public function ticket(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|exists:drivers,id',
                'pcn' => 'required',
                'date' => 'required',
                'price' => 'required',
                'ticket_issuer' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'status' => false
                ]);
            } else {
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
            }
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
                'tickets' => $tickets
            ], 200);
        }
    }
    public function carResponse(Request $request)
    {
    }
}
