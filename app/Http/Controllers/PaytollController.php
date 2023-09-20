<?php

namespace App\Http\Controllers;

use App\Models\Paytoll;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValueMap;

class PaytollController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:toll-list|toll-pay|toll-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:toll-pay', ['only' => ['paytoll']]);
        $this->middleware('permission:toll-create', ['only' => ['createToll']]);
        $this->middleware('permission:toll-edit', ['only' => ['editToll']]);
        $this->middleware('permission:toll-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $tolls = Paytoll::all();
        foreach ($tolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }
        return view('toll.index', compact('tolls'));
    }
    public function destory($id)
    {
        $toll = Paytoll::findorFail($id);
        $toll->destory();
        return redirect()->back()->with('success', 'Toll has been deleted');
    }
    public function paytoll($id)
    {
        $toll = Paytoll::find($id);
        $status = $toll->status;
        if ($status == '1') {
            return redirect()->route('toll')->with('error', 'Toll is already paid');
        } else if ($status == '0') {
            $toll->status = '1';
            $toll->save();
            return redirect()->back()->with('success', 'Toll has been paid');
        } elseif ($status == 2) {
            return redirect()->back()->with('error', 'Toll status is disputed');
        } else {
            return redirect()->back()->with('error', 'Erorr occured.');
        }
    }
    public function createToll(Paytoll $toll)
    {
        return view('toll.create', compact('toll'));
    }
    public function storeToll(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|integer',
                'days' => 'required|array',
                'status' => 'boolean',
            ]);

            // Retrieve existing tolls with the same name
            $existingTolls = Paytoll::where('name', $data['name'])->get();

            // Check if any existing toll has overlapping days with the new toll
            foreach ($existingTolls as $existingToll) {
                // Convert JSON days arrays to sets for easy comparison
                $existingDays = collect(json_decode($existingToll->days));
                $newDays = collect($data['days']);

                // Check if there are overlapping days (intersection of sets is not empty)
                if (!$existingDays->intersect($newDays)->isEmpty()) {
                    return redirect()->route('toll.create')->with('error', 'Toll with the same name already exists with overlapping days.');
                }
            }

            $toll = new Paytoll($data);
            $toll->days = json_encode($data['days']);
            $toll->save();

            return redirect()->route('toll')->with('success', 'Toll has been created successfully.');
        } catch (\Exception $e) {

            return back()->with('error', $e . 'Failed to create toll. Please try again.');
        }
    }
    public function editToll($id)
    {
        $tolls = Paytoll::find($id);
        $tolls->selectedDays = json_decode($tolls->days);
        return view('toll.edit', compact('tolls'));
    }
    public function updateToll(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|integer',
                'days' => 'required|array',
                'status' => 'boolean',
            ]);
        
            $toll = Paytoll::find($id);
        
            // Check if there are overlapping days with other tolls of the same name
            $existingTolls = Paytoll::where('name', $data['name'])
                ->where('id', '<>', $id) // Exclude the current toll being updated
                ->get();
        
            foreach ($existingTolls as $existingToll) {
                // Convert JSON days arrays to sets for easy comparison
                $existingDays = collect(json_decode($existingToll->days));
                $newDays = collect($data['days']);
        
                // Check if there are overlapping days
                if (!$existingDays->intersect($newDays)->isEmpty()) {
                    return redirect()->route('toll.edit', $id)->with('error', 'Toll with the same name already exists with overlapping days.');
                }
            }
            // If no overlapping days are found, update the toll
            $toll->update($data);
            return redirect()->route('toll')->with('success', 'Toll has been updated successfully.');
        } catch (\Exception $e) {
            // Log the exception for debugging

            return back()->with('error','Failed to update toll. Please try again.');
        }
    }
    public function delete($id)
    {
        $toll = Paytoll::find($id);
        $toll->delete();
        return redirect()->route('toll')->with('success', 'Toll has been deleted Successfully');
    }
}
