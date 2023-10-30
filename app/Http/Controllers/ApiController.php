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
use GuzzleHttp\Client;
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
        $data = $request->input(); // Get the entire request data as an array.

        $driverId = $data['driver_id'];
        $date = $data['date'];
        $cities = $data['cities'];

        foreach ($cities as $city) {
            $cityId = $city['city_id'];
            $note = $city['notes'];

            $userId = Driver::where('id', $driverId)->value('user_id');
            $uuid = Uuid::uuid4()->toString();

            DB::table('city__drivers')->insert([
                'cd' => $uuid,
                'city_id' => $cityId,
                'driver_id' => $driverId,
                'date' => $date,
                'notes' => $note,
                'user_id' => $userId,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'IDs stored successfully',
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

        $data = $request->input(); // Get the entire request data as an array.

        $driverId = $data['driver_id'];
        $date = $data['date'];
        $way = $data['way'];
        $tolls = $data['tolls'];

        foreach ($tolls as $toll) {
            $tollId = $toll['toll_id'];
            $note = $toll['notes'];

            $userId = Driver::where('id', $driverId)->value('user_id');
            $uuid = Uuid::uuid4()->toString();

            DB::table('paytoll__drivers')->insert([
                'pd' => $uuid,
                'paytoll_id' => $tollId,
                'driver_id' => $driverId,
                'way' => $way,
                'date' => $date,
                'notes' => $note,
                'user_id' => $userId,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'IDs stored successfully',
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
                'notes' => 'nullable',
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
                    'notes' => 'nullable',

                ]);

                Ticket::create($validateData);
                return response()->json([
                    'message' => 'ticket is stored',
                    'status' => true,
                ], 200);
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

        // $tickets = Ticket::where('driver_id', $id)->get();
        // $tolls = DB::table('paytolls')
        //     ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
        //     ->where('paytoll__drivers.driver_id', $id)
        //     ->select('paytolls.name', 'paytoll__drivers.*')
        //     ->get();

        $tickets = Ticket::where('driver_id', $id)
            ->select('*', DB::raw("COALESCE(notes, '{}') as notes"))
            ->get();

        $tolls = DB::table('paytolls')
            ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
            ->where('paytoll__drivers.driver_id', $id)
            ->select('paytolls.name', 'paytoll__drivers.*')
            ->selectRaw('COALESCE(paytoll__drivers.notes, "{}") as notes')
            ->get();


        $city = DB::table('cities')
            ->leftJoin('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
            ->where('city__drivers.driver_id', $id)
            ->select('cities.area as name', 'city__drivers.*')
            ->selectRaw('COALESCE(city__drivers.notes, "{}") as notes')
            ->get();



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
    public function addNotes(Request $request)
    {
        $t_id = $request->input('ticket_id');
        $notes = $request->input('notes');
        $p_id = $request->input('pd');
        $c_id = $request->input('cd');
        $tickets = Ticket::findOrFail($t_id)->first();
        $tolls = Paytoll_Driver::where('pd', $p_id)->first();
        $city = City_Driver::where('cd', $c_id)->first();

        if ($tickets == null && $tolls == null && $city == null) {
            return response()->json([
                'message' => 'No data found for this driver',
                'status' => true,
            ]);
        } elseif ($tickets !== null) {
            $tickets->notes = $notes;
            $tickets->save();
        } elseif ($tolls !== null) {
            $tolls->notes = $notes;
            $tolls->save();
        } elseif ($city !== null) {
            $city->notes = $notes;
            $city->save();
        }

        return response()->json([
            'message' => 'Data is stored',
            'status' => true,
        ]);
    }
}
