<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:car-list|car-create|car-edit|car-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:car-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:car-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:car-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }
    public function create()
    {
        return view('cars.create');
    }
    public function edit($id)
    {
        $car = Car::find($id);
        return view('cars.edit', compact('car'));
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'make' => 'required',
                'dor' => 'required',
                'year' => 'required',
                'capacity' => 'required',
                'co' => 'required',
                'fuel' => 'required',
                'euro' => 'required',
                'rde' => 'required',
                'export' => 'required',
                'status' => 'required',
                'number' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($image = $request->file('image')) {
                $destinationPath = 'image/';
                $imageName = $validateData['number'] . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
                $validateData['image'] = $imageName;
            }
            Car::create($validateData);

            return redirect()->route('cars.index')->with('success', 'Car created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e . 'Failed to create driver. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);
        return view('cars.show', compact('car'));
    }


    public function update(Request $request, Car $car)
    {
        try {
            $validateData = $request->validate([
                'make' => 'required',
                'dor' => 'required',
                'year' => 'required',
                'capacity' => 'required',
                'co' => 'required',
                'fuel' => 'required',
                'euro' => 'required',
                'rde' => 'required',
                'export' => 'required',
                'status' => 'required',
                'number' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
    
            if ($image = $request->file('image')) {
                $destinationPath = 'image/';
                $imageName = $validateData['number'] . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
                $validateData['image'] = $imageName;
            }
                // Delete the old image if it exists
                if ($car->image) {
                    $oldImagePath ='image/' . $car->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            $car->update($validateData);
    
            return redirect()->route('cars.index')
                ->with('success', 'Car updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update the car. Please try again.');
        }
    }
    
    public function delete($id)
    {
        $car = Car::find($id);
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
    }
}
