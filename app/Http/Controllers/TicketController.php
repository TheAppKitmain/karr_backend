<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Paytoll;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;

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

    // *************************** Functions for Payment *******************************************

    public function paycharges($id)
    {
        $city = DB::table('city_driver')->where('city_id', $id)->first();
        $find = City::find($id);
        $price = $find->price;
        $name = 'ct';
        $type = $city->city_id;
        $status = $city->status;
        if ($status == '0') {
           return view('ticket.stripe', compact('type','price', 'name'));
        } else if ($status == '1') {
            return redirect()->route('tickets')->with('error', 'City Charges is paid');
        } elseif ($status == '2') {
            return redirect()->back()->with('error', 'City Charges has disputed status');
        } else {
            return redirect()->back()->with('error', 'Error occured');
        }
    }


    public function payticket($id)
    {
        $ticket = Ticket::find($id);
        $status = $ticket->status;
        $name = 'tk';
        $type = $ticket->id;
        $price = $ticket->price;
        if ($status == 0) {
            return view('ticket.stripe',compact('type','price', 'name'));
        } else if ($status == 1) {
         return redirect()->route('tickets')->with('error', 'Ticket is paid');
        } else {
            return redirect()->route('tickets')->with('error', 'Ticket status is disputed');
        }
    }


    // ************************************** Stripe Functions *************************************************
    public function stripe(Request $request, $id)
    {
        try {
            $name = $request->type;
            $amount = $request->price * 100;
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "gbp",
                "source" => $request->stripeToken,
                "description" => "Test payment for KARR."
            ]);
            if($name == 'tk')
            {
                $ticket = Ticket::find($id);
                $ticket->status = 1;
                $ticket->save();
                return back()->with('success', 'Payment successful!');
            }
            else if($name == 'tl')
            {
                DB::table('driver_paytoll')->where('paytoll_id', $id)->update(array('status' => 1));
                return back()->with('success', 'Payment successful!');
            }
            else if ($name == 'ct')
            {
                DB::table('city_driver')->where('city_id', $id)->update(array('status' => '1'));
                return back()->with('success', 'Payment successful!');
            }

        } catch (Exception $e) {
            return back()->with('error', 'Error Occured');
        }
    }

    public function selectMultiple(Request $request)
    {
        $encodedIds = $request->input('ids');
    
        // Decode the JSON-encoded IDs and convert them back to an array
        $selectedIds = json_decode(urldecode($encodedIds), true);
    
        // Initialize the total price and arrays for IDs
        $totalPrice = 0;
        $tids = [];
        $lids = [];
        $cids = [];
    
        // Process the selected IDs for each table
        foreach ($selectedIds as $table => $ids) {
            foreach ($ids as $id) {
                $item = null;
    
                // Determine the model based on the table name
                switch ($table) {
                    case 'tickets':
                        $item = Ticket::find($id);
                        $tid = $item->id;
                        $tids[] = $tid;
                        break;
                    case 'tolls':
                        $item = PayToll::find($id);
                        $toll = DB::table('driver_paytoll')->where('paytoll_id', $id)->first();
                        $lid = $toll->paytoll_id;
                        $lids[] = $lid;
                        break;
                    case 'city':
                        $item = City::find($id);
                        $city = DB::table('city_driver')->where('city_id', $id)->first();
                        $cid = $city->city_id;
                        $cids[] = $cid;
                        break;
                    // Add more cases for other tables if needed
                }
    
                if ($item) {
                    $totalPrice += $item->price;
                }
            }
        }
    
        //  dd($tids,$cids, $lids);
    
        return view('ticket.bulk', compact('totalPrice', 'tids', 'lids', 'cids'));
    }
    
    public function bulkStripe(Request $request)
    {
        $amount = $request->price * 100;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $amount,
            "currency" => "gbp",
            "source" => $request->stripeToken,
            "description" => "Test payment for KARR."
        ]);
        $cidsJson = $request->input('cids');
        $cids = json_decode($cidsJson, true);
        $tidsJson = $request->input('tids');
        $tids = json_decode( $tidsJson, true);
        $lidsJson = $request->input('lids');
        $lids = json_decode( $lidsJson, true);
        foreach ($lids as $lid)
        {
            DB::table('driver_paytoll')->where('paytoll_id', $lid)->update(array('status' => 1));
        }
        foreach ($cids as $cid)
        {
            DB::table('city_driver')->where('city_id', $cid)->update(array('status' => 1));
        }
        foreach($tids as $tid)
        {
            $ticket = Ticket::find($tid);
            $ticket->status = 1;
            $ticket->save();
        }
        // dd($cids,$lids,$tids);
        return redirect()->route('tickets')->with('success', 'Payment has been done');
    }

}
