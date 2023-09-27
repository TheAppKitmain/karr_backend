<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Paytoll;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ticket-list|ticket-pay', ['only' => ['index', 'store']]);
        $this->middleware('permission:ticket-delete', ['only' => ['ticketDelete']]);
        $this->middleware('permission:charges-list', ['only' => ['city']]);
        $this->middleware('permission:charges-create', ['only' => ['cityCreate']]);
        $this->middleware('permission:charges-edit', ['only' => ['cityEdit']]);
        $this->middleware('permission:charges-delete', ['only' => ['cityDelete']]);
        $this->middleware('permission:charges-pay', ['only' => ['paycharges']]);
    }
    public function index()
    {
        $tickets = Ticket::all();
        $cities = DB::table('cities')
            ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
            ->select('cities.*', 'city_driver.*')
            ->get();
        $tolls = DB::table('paytolls')
            ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
            ->select('paytolls.*', 'driver_paytoll.*')
            ->get();
        foreach ($tolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }
        return view('ticket.index', compact('tickets', 'tolls', 'cities'));
    }
    public function payticket($id)
    {
        $ticket = Ticket::find($id);
        $status = $ticket->status;
        if ($status == 1) {
            return redirect()->route('tickets')->with('error', 'Ticket is already paid');
        } else if ($status == 0) {
            $ticket->status = 1;
            $ticket->save();
            return redirect()->route('tickets')->with('success', 'Ticket has been paid');
        } else {
            return redirect()->route('tickets')->with('error', 'Ticket status is disputed');
        }
    }
    public function ticketDelete($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->route('tickets')->with('success', 'Ticket has been deleted');
    }


    // *************************** Functions for City Charges *******************************************


    public function city()
    {
        $charges = City::all();
        return view('charges.index', compact('charges'));
    }
    public function paycharges($id)
    {
        $charges = DB::table('city_driver')->where('city_id', $id)->first();
        $status = $charges->status;
        if ($status == '1') {
            return redirect()->route('city')->with('error', 'City Charges is already payed');
        } else if ($status == '0') {
            DB::table('city_driver')->where('city_id', $id)->update(array('status' => '1'));
            return redirect()->back()->with('success', 'City Charges has been paid');
        } elseif ($status== '2') {
            return redirect()->back()->with('error', 'City Charges has disputed status');
        }
        else{
            return redirect()->back()->with('error', 'Error occured');
        }
    }

    public function cityCreate(City $city)
    {
        return view('charges.create', compact('city'));
    }
    public function cityStore(Request $request)
    {
        try {
            $request->validate([
                'area' => 'required|string',
                'time' => 'required|string',
                'city' => 'required',
                'price' => 'required',
            ]);
            $input = $request->all();
            City::create($input);

            return redirect()->route('city')->with('success', 'City charges has been created successfully.');
        } catch (\Exception $e) {

            return back()->with('error', 'Failed to create charges. Please try again.');
        }
    }
    public function cityDelete($id)
    {
        $city = City::find($id);
        $city->delete();
        return redirect()->route('city')->with('success', 'City charges has been deleted successfully.');
    }
    public function cityEdit($id)
    {
        $charge = City::find($id);
        return view('charges.edit', compact('charge'));
    }
    public function cityUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'area' => 'required|string',
                'time' => 'required|string',
                'city' => 'required',
                'price' => 'required|string',
            ]);
            $input = $request->all();
            $city = City::find($id);
            $city->update($input);

            return redirect()->route('city')->with('success', 'City charges has been updated successfully.');
        } catch (\Exception $e) {
            // Log the exception for debugging

            return back()->with('error', 'Failed to update charges. Please try again.');
        }
    }
}
