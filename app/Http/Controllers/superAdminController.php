<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\City;
use App\Models\City_Driver;
use App\Models\Paytoll;
use App\Models\Paytoll_Driver;
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
        // $this->middleware('permission::admin-pay', ['only' => ['adminPay']]);
    }

    public function adminData($id)
    {
        $ticketData = Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $tollData = DB::table('paytolls')
        ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
        ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
        ->where('drivers.user_id', $id)
        ->select('paytolls.*', 'drivers.name As user_name','paytoll__drivers.*')
        ->get();
        // return $tollData;
        $cityData = DB::table('cities')
        ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
        ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
        ->where('drivers.user_id', $id)
        ->select('cities.*','drivers.name As user_name', 'city__drivers.*')
        ->get();

        $bank = Card::where('user_id', $id)->get();

        $unpaidTickets = Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->count() + Paytoll::whereHas('tollDrivers.driver.user', function ($query) use ($id) {
            $query->where('users.id', $id)->where('status', '0');
        })->count() +   City::whereHas('cityDrivers.driver.user', function ($query) use ($id) {
            $query->where('users.id', $id)->where('status', '0');
        })->count();

        $unpaidCharges =  Paytoll::whereHas('tollDrivers.driver.user', function ($query) use ($id) {
            $query->where('users.id', $id)->where('status', '0');
        })->sum('price') +   City::whereHas('cityDrivers.driver.user', function ($query) use ($id) {
            $query->where('users.id', $id)->where('status', '0');
        })->sum('price') + Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id)->where('status', 0);
        })->sum('price');

        $totalCharges = Paytoll::whereHas('tollDrivers.driver.user', function ($query) use ($id) {
            $query->where('users.id', $id);
        })->sum('price') +   City::whereHas('cityDrivers.driver.user', function ($query) use ($id) {
            $query->where('users.id', $id);
        })->sum('price') + Ticket::whereHas('driver.user', function ($query) use ($id) {
            $query->where('id', $id);
        })->sum('price');


        return view('superAdmin.adminDetail', compact(
            'ticketData',
            'cityData',
            'tollData',
            'bank',
            'unpaidTickets',
            'unpaidCharges',
            'totalCharges'

        ));
    }

    public function totalTickets()
    {

        $tickets = DB::table('tickets')
        ->join('drivers', 'tickets.driver_id', '=', 'drivers.id')
        ->join('users', 'drivers.user_id', '=', 'users.id')
        ->select('tickets.*' ,'drivers.name as driver', 'users.name as user_name')
        ->get();

        $cities = DB::table('cities')
        ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
        ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
        ->join('users', 'drivers.user_id', '=', 'users.id')
        ->select('cities.*', 'city__drivers.*','drivers.name as driver', 'users.name as user_name')
        ->get();


        $tolls = DB::table('paytolls')
        ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
        ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
        ->join('users', 'drivers.user_id', '=', 'users.id')
        ->select('paytolls.*', 'paytoll__drivers.*', 'users.name as user_name')
        ->get();
    
        foreach ($tolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }

        $unpaidTickets = Ticket::where('status', '0')->get();
        $paidTickets = Ticket::where('status', '1')->get();

        $unpaidTolls = DB::table('paytolls')
            ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
            ->select('paytolls.*', 'paytoll__drivers.*')
            ->where('paytoll__drivers.status', 0)->get();
        foreach ($unpaidTolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }


        $paidTolls = DB::table('paytolls')
            ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
            ->select('paytolls.*', 'paytoll__drivers.*')
            ->where('paytoll__drivers.status', 1)->get();
        foreach ($paidTolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }

        $unpaidCharges = DB::table('cities')
            ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
            ->select('cities.*', 'city__drivers.*')->where('city__drivers.status', 0)->get();

        $paidCharges = DB::table('cities')
            ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
            ->select('cities.*', 'city__drivers.*')->where('city__drivers.status', 1)->get();


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

    public function adminPay($id, $name, $d_id)
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
            $toll = Paytoll_Driver::where('paytoll_id', $id)
                ->where('pd', $d_id)
                ->first();
            if ($toll->status == 0) {
                $toll->status = 1;
                $toll->save();
                return back()->with('success', 'Toll has been paid');
            } elseif ($toll->status == 1) {
                return back()->with('error', 'Toll has been already paid');
            }
        } elseif ($name == 'ct') {
            $city = City_Driver::where('city_id', $id)->where('cd', $d_id)->first();
            // return $city;
            if ($city->status == 0) {
                $city->status = 1;
                $city->save();
                return back()->with('success', 'City Charges has been paid');
            } elseif ($city->status == 1) {
                return back()->with('error', 'City charges has been already paid');
            }
        }
    }

    public function markedPay(Request $request)
    {
        $items = $request->query('items');
        $selectedItems = json_decode($items); 
        foreach ($selectedItems as $item) {
            $table = $item->table;      // table has name of the table.
            $tid = $item->toll_id;      // toll_id is has ticket_id, paytoll_id, city_id.
            $did = $item->driver_id;    // In driver_id (in ticket case (driver_id),
                                        // in paytoll and city (cd,pd) which is unique key. 

            switch ($table) {
                case 'tickets':
                    $item = Ticket::find($tid);
                    if ($item->status == '1') {
                        return back()->with('error', 'selected ticket is already paid');
                    } else {
                        $item->status = 1;
                        $item->save();
                        break;
                    }
                case 'tolls':
                    $toll = Paytoll_Driver::where('paytoll_id', $tid)->where('pd', $did)->first();
                    // return $toll;
                    if ($toll->status == 1) {
                        return back()->with('error', 'selected ticket is already paid');
                    } else {

                        $toll->status = 1;
                        $toll->save();
                        break;
                    }
                case 'city':
                    $city = City_Driver::where('city_id', $tid)->where('cd', $did)->first();
                    if ($city->status == '1') {
                        return back()->with('error', 'selected ticket is already paid');
                    } else {
                        $city->status = 1;
                        $city->save();
                        break;
                    }
            }
        }
        return back()->with('success', 'tickets paid');
    }
    public function unpaid($id, $name, $d_id)
    {
        if ($name == 'tk') {
            $ticket = Ticket::find($id);
            if ($ticket->status == 0) {
                return back()->with('error', 'Ticket is already unpaid');
            } elseif ($ticket->status == 1) {
                $ticket->status = 0;
                $ticket->save();
                return back()->with('success', 'Ticket has been marked unpaid');
            }
        } elseif ($name == 'tl') {
            $toll = Paytoll_Driver::where('paytoll_id', $id)
                ->where('pd', $d_id)
                ->first();
            if ($toll->status == 1) {
                $toll->status = 0;
                $toll->save();
                return back()->with('success', 'Toll has been marked unpaid');
            } elseif ($toll->status == 1) {
                return back()->with('error', 'Toll has been already unpaid');
            }
        } elseif ($name == 'ct') {
            $city = City_Driver::where('city_id', $id)->where('cd', $d_id)->first();
            // return $city;
            if ($city->status == 1) {
                $city->status = 0;
                $city->save();
                return back()->with('success', 'City Charges has been  marked unpaid');
            } elseif ($city->status == 1) {
                return back()->with('error', 'City charges has been already unpaid');
            }
        }
    }
}
