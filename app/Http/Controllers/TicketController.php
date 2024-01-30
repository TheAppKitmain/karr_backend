<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\City;
use App\Models\City_Driver;
use App\Models\Paytoll;
use App\Models\Paytoll_Driver;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $userId = Auth::user()->id;
        $tickets = Ticket::whereHas('driver.user', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->paginate(5);
        $unpaid = Ticket::whereHas('driver.user', function ($query) use ($userId) {
            $query->where('id', $userId)->where('status', '0');
        })->paginate(5);
        $paid = Ticket::whereHas('driver.user', function ($query) use ($userId) {
            $query->where('id', $userId)->where('status', '1');
        })->paginate(5);
    //    return $paid;
        return view('ticket.index', compact('tickets','paid','unpaid'));
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
        $city->cityDrivers()->delete();
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

    public function paycharges($id, $did)
    {

        $type = City_Driver::where('city_id', $id)->where('cd', $did)->first();
        $name = 'ct';
        $city  = City::find($id);
        $price = $city->price;
        //  return $type;
        $collection = Card::where('user_id', Auth::user()->id)->get();
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


    public function payticket($id)
    {
        $type = Ticket::find($id);
        $status = $type->status;
        $collection = Card::where('user_id', Auth::user()->id)->get();
        $name = 'tk';
        $price = $type->price;
        if ($status == 0) {
            return view('ticket.stripe', compact('type', 'price', 'name', 'collection'));
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
            if ($name == 'tk') {
                $ticket = Ticket::find($id);
                $ticket->status = 1;
                $ticket->save();
                return back()->with('success', 'Payment successful!');
            } else if ($name == 'tl') {
                // dd($id);
                $toll = Paytoll_Driver::find($id);
                $toll->status = 1;
                $toll->save();
                return back()->with('success', 'Payment successful!');
            } else if ($name == 'ct') {
                $city = City_Driver::find($id);
                $city->status = 1;
                $city->save();
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
                        if ($item->status == '1') {
                            return back()->with('error', 'selected ticket is already paid');
                        } else {
                            $tids[] = $tid;
                            break;
                        }
                    case 'tolls':
                        $toll = Paytoll_Driver::where('pd', $id)->first();
                        $item = Paytoll::where('id',$toll->paytoll_id)->first();
                        // return $toll;
                        if ($toll->status == 1) {
                            return back()->with('error', 'selected ticket is already paid');
                        } else {
                            $lid = $toll->pd;
                            $lids[] = $lid;
                            break;
                        }
                    case 'city':
                        $city = City_Driver::where('cd', $id)->first();
                        $item = City::where('id',$city->city_id)->first();
                        $cid = $city->cd;
                        if ($city->status == '1') {
                            return back()->with('error', 'selected ticket is already paid');
                        } else {
                            $cids[] = $cid;
                            break;
                        }
                        // Add more cases for other tables if needed
                }

                if ($item) {
                    $totalPrice += $item->price;
                }
            }
        }
        $collection = Card::all();

        return view('ticket.bulk', compact('totalPrice', 'tids', 'lids', 'cids', 'collection'));
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
        $tids = json_decode($tidsJson, true);
        $lidsJson = $request->input('lids');
        $lids = json_decode($lidsJson, true);
        foreach ($lids as $lid) {
            $toll = Paytoll_Driver::where('pd', $lid)->first();
            $toll->status = 1;
            $toll->save();
        }
        foreach ($cids as $cid) {
            $city = City_Driver::where('cd', $cid)->first();
            $city->status = 1;
            $city->save();
        }
        foreach ($tids as $tid) {
            $ticket = Ticket::find($tid);
            $ticket->status = 1;
            $ticket->save();
        }
        // dd($cids,$lids,$tids);
        return redirect()->back()->with('success', 'Payment has been done');
    }
    public function deleteTicket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->route('tickets')->with('success', 'Deleted');
    }
}
