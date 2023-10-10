<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\City;
use App\Models\Paytoll;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class superAdminController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:admin-list', ['only' => ['adminData']]);
        $this->middleware('permission:admin-ticket', ['only' => ['totalTickets']]);
        $this->middleware('permission::admin-pay', ['only' => ['adminPay']]);
        // $this->middleware('permission:toll-create', ['only' => ['createToll']]);
        // $this->middleware('permission:toll-edit', ['only' => ['editToll']]);
        // $this->middleware('permission:toll-delete', ['only' => ['destroy']]);
    }

    public function adminData($id)
    {
        $ticketData = Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $tollData = Paytoll::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $cityData = City::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $bank = Card::where('user_id', $id)->get();

        $unpaidTickets = Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->count() + Paytoll::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->count() +   City::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->count();

        $unpaidCharges = Paytoll::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price') +   City::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price') + Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price');

        $totalCharges = Paytoll::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price') +   City::whereHas('drivers.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price') + Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price');

        return view('superAdmin.adminDetail', compact('ticketData',
         'cityData', 'tollData', 'bank', 'unpaidTickets', 'unpaidCharges', 'totalCharges'
        
        ));
    }

    public function totalTickets()
    {
        $tickets = Ticket::all();
        $cities = DB::table('cities')
            ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
            ->select('cities.*', 'city_driver.*')->get();

        $tolls = DB::table('paytolls')
            ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
            ->select('paytolls.*', 'driver_paytoll.*')
            ->get();
        foreach ($tolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }

        $unpaidTickets = Ticket::where('status', '0')->get();
        $paidTickets = Ticket::where('status', '1')->get();

        $unpaidTolls = DB::table('paytolls')
            ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
            ->select('paytolls.*', 'driver_paytoll.*')
            ->where('driver_paytoll.status', 0)->get();
        foreach ($unpaidTolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }


        $paidTolls = DB::table('paytolls')
            ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
            ->select('paytolls.*', 'driver_paytoll.*')
            ->where('driver_paytoll.status', 1)->get();
        foreach ($paidTolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }

        $unpaidCharges = DB::table('cities')
            ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
            ->select('cities.*', 'city_driver.*')->where('city_driver.status', 0)->get();

        $paidCharges = DB::table('cities')
            ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
            ->select('cities.*', 'city_driver.*')->where('city_driver.status', 1)->get();


        return view('superAdmin.allTickets', compact(
            'tickets',
            'tolls',
            'cities',
            'unpaidTickets',
            'paidTickets',
            'unpaidTolls',
            'paidTolls',
            'unpaidCharges',
            'paidCharges'
        ));
    }

    public function adminPay($id, $name)
    {
        if ($name == 'tk') {
            $ticket = Ticket::find($id);
            if ($ticket->status == 1) {
                return back()->with('error', 'Ticket is already paid');
            } elseif ($ticket->status == 0) {
                $ticket->status = 1;
                $ticket->save();
                return back()->with('success', 'Ticket has been paid');
            }
        } elseif ($name == 'tl') {
            $status = DB::table('driver_paytoll')->where('paytoll_id', $id)
                ->select('status')->first();

            if ($status) {

                DB::table('driver_paytoll')->where('paytoll_id', $id)->update(array('status' => 1));
                return back()->with('success', 'Toll has been paid');
            } elseif ($status == 1) {
                return back()->with('error', 'Toll has been already paid');
            }
        } elseif ($name == 'ct') {
            $city = DB::table('city_driver')->where('city_id', $id)->select('status')->first();
            if ($city->status == 0) {

                DB::table('city_driver')->where('city_id', $id)->update(array('status' => 1));
                return back()->with('success', 'City Charges has been paid');
            } elseif ($city->status == 1) {
                return back()->with('error', 'City charges has been already paid');
            }
        }
    }

    public function markedPay(Request $request)
    {
        $encodedIds = $request->input('ids');

        // Decode the JSON-encoded IDs and convert them back to an array
        $selectedIds = json_decode(urldecode($encodedIds), true);

        // Initialize the total price and arrays for IDs
        $totalPrice = 0;
        $tids = [];
        $lids = [];
        $cids = [];
    }
}
