<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\City_Driver;
use App\Models\Driver;
use App\Models\Paytoll;
use App\Models\Paytoll_Driver;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('number', 'password', 'email');
        $driver = Driver::where('email', $credentials['email'])->first();

        if ($driver && Hash::check($credentials['password'], $driver->password) && $driver->number === $credentials['number']) {
            $userId = $driver->user_id;
            $user = User::find($userId);
            $image = $user->image;
            if ($image == null) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'user' => $driver,
                    'logo' => 'No image found',
                ], 200);
            } else {
                $imageUrl = 'https://codecoyapps.com/karr/public/image/' . $image;
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'user' => $driver,
                    'logo' => $imageUrl,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Login failed'
            ], 200);
        }
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
            $userId = Driver::where('id', $driverId)->value('user_id');
            $uuid = Uuid::uuid4()->toString();

            DB::table('city__drivers')->insert([
                'cd' => $uuid,
                'city_id' => $cityId,
                'driver_id' => $driverId,
                'date' => $date,
                'notes' => $notes,
                'user_id' => $userId,
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
            $userId = Driver::where('id', $driverId)->value('user_id');
            $uuid = Uuid::uuid4()->toString();
            DB::table('paytoll__drivers')->insert([
                'pd' => $uuid,
                'paytoll_id' => $tollId,
                'driver_id' => $driverId,
                'way' => $way,
                'date' => $date,
                'notes' => $notes,
                'user_id' => $userId,
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
    public function recentActivity(Request $request)
    {
        $id = $request->input('driver_id');
        $driver = Driver::find($id);

        if ($driver === null) {
            return response()->json([
                'message' => 'No Driver found for this driver_id',
                'status' => false,
            ]);
        }

        $tickets = Ticket::where('driver_id', $id)->get();
        $tolls = Paytoll_Driver::where('driver_id', $id)->get();
        $city = City_Driver::where('driver_id', $id)->get();

        if ($tickets->isEmpty() && $tolls->isEmpty() && $city->isEmpty()) {
            return response()->json([
                'message' => 'No data found for this driver',
                'status' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'Data found for this driver',
                'tickets' => $tickets,
                'tolls' => $tolls,
                'charges' => $city,
                'status' => true,
            ]);
        }
    }
}
