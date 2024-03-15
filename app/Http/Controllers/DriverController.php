<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DriversImport;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
            $drivers = Driver::orderBy('created_at', 'desc')->get();
            return view('drivers.index', compact('drivers'));
        }
        // For Admin
        elseif ($roles->contains('name', 'Admin')) {
            $drivers = Driver::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            return view('drivers.index', compact('drivers'));
        }
    }
    public function create()
    {
        $id = Auth::user()->id;
        $user = Auth::user();
        $roles = $user->roles;

        // For Super Admins
        if ($roles->contains('name', 'Super Admin')) {
            $adminData = Role::where('name', 'Admin')->get();

            if ($adminData) {
                $users = collect();

                foreach ($adminData as $role) {

                    $businesses = $users->merge($role->users);
                }
                return view('drivers.create', compact('businesses'));
            }
        }

        // For Admin
        elseif ($roles->contains('name', 'Admin')) {
            $businesses = User::where('id', $id)->get();
            return view('drivers.create', compact('businesses'));
        }
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
                'business' => 'required'
            ]);

            $user = Driver::where('email', '=', $validateData['email'])->first();
            if ($user === null) {

                $input = $request->all();
                $input['password'] = Hash::make($input['password']);
                $user = User::where('business', $request->business)->first();
                $input['user_id'] = $user->id;
                Driver::create($input);

                return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
            } else {
                return redirect()->back()->with('error', 'Driver with this email already exist.');
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Failed to create driver: ' . $e->getMessage());

            return back()->with('error', 'Failed to create driver. Please try again.' . $e->getMessage());
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
            // Define validation rules
            $validateData = $request->validate([
                'name' => 'required|string',
                'license' => 'required|string',
                'number' => 'required|string',
                'password' => 'nullable|same:confirm-password',
                'email' => 'required',
            ]);

            // If password is provided, add password validation rule
            $driver = Driver::find($id);

            $driver->name = $validateData['name'];
            $driver->email = $validateData['email'];
            $driver->number = $validateData['number'];
            $driver->license = $validateData['license'];

            if (!empty($validatedData['password'])) {
                $driver->password = Hash::make($validatedData['password']);
            }
            // Update the driver
            $driver->save();

            return redirect()->route('drivers.index')->with('success', 'Driver updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update driver.' . $e->getMessage());
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
        $driver->fines()->delete();
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
