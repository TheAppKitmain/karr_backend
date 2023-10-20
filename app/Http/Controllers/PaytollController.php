<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Card;
use App\Models\Paytoll;
use App\Models\Paytoll_Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $userId = Auth::user()->id;
        $tolls = DB::table('paytolls')
        ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
        ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
        ->where('drivers.user_id', $userId)
        ->select('paytolls.*', 'paytoll__drivers.*')
        ->get();

        foreach ($tolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }

        $cities = DB::table('cities')
        ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
        ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
        ->where('drivers.user_id', $userId)
        ->select('cities.*', 'city__drivers.*')
        ->get();

        return view('toll.index', compact('tolls','cities'));
    }
    public function destory($id)
    {
        $toll = Paytoll::findorFail($id);
        $toll->destory();
        return redirect()->back()->with('success', 'Toll has been deleted');
    }
    public function paytoll($id,$did)
    {
        $type = Paytoll_Driver::where('pd', $did)->first();
        $name = 'tl';
        $toll  = Paytoll::find($id);
        $price = $toll->price;
        $collection = Card::where('user_id', Auth::user()->id)->get();
        // return $collection;
        if ($type->status == '0') {
            return view('ticket.stripe', compact('type', 'name', 'collection', 'price'));
        } 
        else if ($type->status == '1') {
            return redirect()->route('tickets')->with('error', 'City Charges is paid');
        } 
        elseif ($type->status == '2') {
            return redirect()->back()->with('error', 'City Charges has disputed status');
        } 
        else {
            return redirect()->back()->with('error', 'Error occured');
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
                'price' => 'required',
                'days' => 'required|array',
                'status' => 'boolean',
            ]);

            $existingTolls = Paytoll::where('name', $data['name'])->get();

            foreach ($existingTolls as $existingToll) {
                $existingDays = collect(json_decode($existingToll->days));
                $newDays = collect($data['days']);
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
                'price' => 'required',
                'days' => 'required|array',
                'status' => 'boolean',
            ]);

            $toll = Paytoll::find($id);


            $existingTolls = Paytoll::where('name', $data['name'])
                ->where('id', '<>', $id)
                ->get();

            foreach ($existingTolls as $existingToll) {
                $existingDays = collect(json_decode($existingToll->days));
                $newDays = collect($data['days']);

                if (!$existingDays->intersect($newDays)->isEmpty()) {
                    return redirect()->route('toll.edit', $id)->with('error', 'Toll with the same name already exists with overlapping days.');
                }
            }
            $toll->update($data);
            return redirect()->route('toll')->with('success', 'Toll has been updated successfully.');
        } catch (\Exception $e) {

            return back()->with('error', 'Failed to update toll. Please try again.');
        }
    }
    public function delete($id)
    {
        $toll = Paytoll::find($id);
        $toll->delete();
        return redirect()->route('toll')->with('success', 'Toll has been deleted Successfully');
    }

    //************************************* Card Save ********************************************/

    public function card(Request $request)
    {
        try {
            $count = Card::all()->count();
            if ($count < 3) {
                $data = $request->validate([
                    'name' => 'required|max:255',
                    'card' => 'required|integer',
                    'cvc' => 'required',
                    'mon' => 'required|max:2',
                    'year' => 'required|max:4',
                    'user_id' => 'required',
                ]);
                Card::create($data);
                return back()->with('success', 'Card is added successfully');
            } else {
                return back()->with('error', 'Already 3 cards are added');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Oops card is not added');
        }
    }
    public function cardDelete($id)
    {
        $card = Card::find($id);
        $card->destory();
        return back()->with('success', 'Card is delete successfully');
    }
}
