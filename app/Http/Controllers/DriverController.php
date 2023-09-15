<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Hash;

class DriverController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:driver-list|driver-create|driver-edit|driver-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:driver-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:driver-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:driver-delete', ['only' => ['destroy']]);
        $this->middleware('permission:driver-assign', ['only' => ['assignDriver','assignCar']]);
        $this->middleware('permission:driver-unassign', ['only' => ['unassign']]);
    }
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.index', compact('drivers'));
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            
            $input = $request->all();
            
            // Hash the password
            $input['password'] = Hash::make($input['password']);
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = 'driver/';
                $imageName = $input['name'] . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->move($destinationPath, $imageName);
                $input['image'] = $imagePath;
            }
            
            // Create the driver
            Driver::create($input);
            
            return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
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


    public function update(Request $request, $id)
    {
        try {
            request()->validate([
                'name' => 'required',
                'number' => 'required',
                'license' => 'required',
                'password' => 'required|min:6',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            // Hash the password
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = 'driver/';
                $imageName = $input['name'] . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->move($destinationPath, $imageName);
                $input['image'] = $imagePath;
            }
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
        return view('charges.drivercharge', compact('driver','charges'));
    }
    public function driverTicket($id)
    { 
        $tickets = Ticket::where('driver_id', $id)->get();
    
        return view('ticket.driverTicket', compact('tickets'));
    }
}
