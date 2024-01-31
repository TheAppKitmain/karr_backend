<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DriversImport;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:driver-list|driver-create|driver-edit|driver-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:driver-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:driver-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:driver-delete', ['only' => ['destroy']]);
        $this->middleware('permission:driver-assign', ['only' => ['assignDriver', 'assignCar']]);
        $this->middleware('permission:driver-unassign', ['only' => ['unassign']]);
    }
    public function index()
    {
        $id = Auth::user()->id;
        $user = Auth::user();
        $roles = $user->roles;

        // For Super Admins
        if ($roles->contains('name', 'Super Admin')) {
            $drivers = Driver::all();
            return view('drivers.index', compact('drivers'));
        }
        // For Admin
        elseif ($roles->contains('name', 'Admin')) {
            $drivers = Driver::where('user_id', $id)->get();
            return view('drivers.index', compact('drivers'));
        }
    }
    public function create()
    {
        return view('drivers.create');
    }
    public function edit($id)
    {
        $driver = Driver::find($id);
        return view('drivers.edit', compact('driver'));
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'license' => 'required|string',
                'number' => 'required|string',
                'password' => 'required|min:6',
                'email' => 'required',
                'user_id' => 'required',
            ]);

            $user = Driver::where('email', '=', $validateData['email'])->first();
            if ($user === null) {

                $input = $request->all();

                // Hash the password
                $input['password'] = Hash::make($input['password']);

                // Create the driver
                Driver::create($input);

                return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
            } else {
                return redirect()->back()->with('error', 'Driver with this email already exits.');
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Failed to create driver: ' . $e->getMessage());

            return back()->with('error', 'Failed to create driver. Please try again.');
        }
    }


    public function show(Driver $drivers)
    {
        return view('drivers.index', compact('drivers'));
    }

    public function download()
    {
        $path = public_path("driver.xlsx");
        session()->flash('success', 'Check your downloads');
        return response()->download($path, 'driver.xlsx');
    }


    public function update(Request $request, $id)
    {
        try {
            request()->validate([
                'name' => 'required',
                'number' => 'required',
                'license' => 'required',
                'password' => 'required|min:6',
                'email' => 'required'
            ]);
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $driver = Driver::find($id);
            $driver->update($input);

            return redirect()->route('drivers.index')
                ->with('success', 'Driver updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create driver. Please try again.');
        }
    }
    public function assigndriver($id)
    {
        $driver = Driver::find($id);
        $cars = Car::doesntHave('driver')->get();
        return view('drivers.assigndriver', compact('driver', 'cars'));
    }
    public function unassign($id)
    {
        $driver = Driver::find($id);
        if ($driver->car_id) {
            $driver->car_id = Null;
            $driver->save();
            return redirect()->route('drivers.index')->with('success', 'Car is unassigned from this driver');
        } else {
            return redirect()->route('drivers.index')->with('error', 'No Car assigned to this driver');
        }
    }
    public function assignCar($id, $driver)
    {
        $drivers = Driver::find($driver);
        if (!$drivers->car_id) {
            $drivers->car_id = $id;
            $drivers->save();
            return redirect()->route('drivers.index')->with('success', 'Car is assigned to the driver');
        } else {
            return redirect()->route('drivers.index')->with('error', 'One Car is already assigned to the driver');
        }
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->cityDrivers()->delete();
        $driver->tickets()->delete();
        $driver->tollDrivers()->delete();
        $driver->fi
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Driver deleted successfully');
    }
    public function driverToll($id)
    {
        $driver = Driver::find($id);
        $tolls = $driver->paytolls;
        return view('toll.driverToll', compact('driver', 'tolls'));
    }
    public function driverCharge($id)
    {
        $driver = Driver::find($id);
        $charges = $driver->cities;
        return view('charges.drivercharge', compact('driver', 'charges'));
    }
    public function driverTicket($id)
    {
        $tickets = Ticket::where('driver_id', $id)->get();

        return view('ticket.driverTicket', compact('tickets'));
    }
    public function import(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|file|mimes:xlsx,csv',
            ]);

            $file = $request->file('file');

            Excel::import(new DriversImport, $file);

            return redirect()->route('drivers.index')
                ->with('success', 'Data imported successfully');
        } catch (\Exception $e) {
            return redirect()->route('drivers.index')
                ->with('error', 'Sorry Data can not be imported due to validation constraints');
        }
    }
}
