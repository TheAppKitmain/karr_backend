<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Paytoll;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $roles = $user->roles;
        //---------------------- For Super Admins---------------------------------------------
        if ($roles->contains('name', 'Super Admin') || $roles->contains('name', 'S Admin')) {

            //--------------------- Tickets, tolls and charges ---------------------------------------------

            $tickets = DB::table('tickets')
                ->join('drivers', 'tickets.driver_id', '=', 'drivers.id')
                ->join('users', 'drivers.user_id', '=', 'users.id')
                ->select('tickets.*', 'drivers.name as driver', 'users.name as user_name')
                ->orderBy('tickets.id', 'desc')->get();

            $tolls = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->join('users', 'drivers.user_id', '=', 'users.id')
                ->select('paytolls.*', 'paytoll__drivers.*', 'users.name as user_name')
                ->orderByDesc('paytoll_id')->take(3)->get();


            // return $cities;
            foreach ($tolls as $toll) {
                $toll->selectedDays = json_decode($toll->days);
            }
            $cities = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->join('users', 'drivers.user_id', '=', 'users.id')
                ->select('cities.*', 'city__drivers.*', 'users.name as user_name')
                ->orderByDesc('city_id')->take(3)->get();

            //--------------- End section --------------------------------------------------

            $charges = City::all()->count();

            $unpaidTicket = Ticket::where('status', '0')->count();
            $unpaidCharges = DB::table('city__driver')->where('status', '0');

            //-------------------- Unpaid Amount/charges --------------------------------------

            $unpaidChargesSum = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->where('city__drivers.status', 0)
                ->sum('cities.price');

            $unpaidTollSum = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->where('paytoll__drivers.status', 0)
                ->sum('paytolls.price');

            $unpaid =  $unpaidChargesSum +  $unpaidTollSum;

            //---------------------------- End Section ------------------------------------

            //---------------------------- Total Amount ----------------------------------

            $citycharges = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->sum('cities.price');
            $tollsCharges =  DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->sum('paytolls.price');

            $totalCharges = $citycharges + $tollsCharges;

            //---------------------------- End Section ------------------------------------

            //---------------------- Unpaid/ paid tickets ---------------------------------
            $unpaidTickets = Ticket::where('status', '0')->get();
            $paidTickets = Ticket::where('status', '1')->get();

            //---------------------------- End Section ------------------------------------

            //------------------- Unpaid tickets tolls and charges -------------------------

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
           
            //---------------------------- End Section ------------------------------------



            // dd($unpaidTickets);

            $page = 'dash';
            return view('home', compact(
                'page',
                'tickets',
                'tolls',
                'cities',
                'charges',
                'unpaidTicket',
                'unpaidCharges',
                'totalCharges',
                'unpaid',
                'unpaidTickets',
                'unpaidTolls',
                'unpaidCities',
                'paidCities',
                'paidTolls',
                'paidTickets',
            ));
        }


        //------------------------------- For Admin -------------------------------------------------

        elseif ($roles->contains('name', 'Admin')) {

            //-----------------Tickets Tolls and charges of admin------------------------------------
            $tickets = Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->get();

            $tolls = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)
                ->select('paytolls.*', 'drivers.name as user_name', 'paytoll__drivers.*')
                ->orderBy('paytolls.id', 'desc')->limit(3)->get();

            $cities = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)
                ->select('cities.*', 'drivers.name as user_name', 'city__drivers.*')
                ->get();

            //----------------------------End Section------------------------------------------

            $charges = City::all()->count();

            $unpaidTicket =  Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '0');
            })->count();

            $unpaidCharges = DB::table('city__drivers')->where('status', '0');

            //------------------------Unpaid Charges-------------------------------------------------

            $unpaidChargesSum =  DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)->where('status', '0')
                ->select('cities.*', 'city__drivers.*')
                ->sum('price');


            $unpaidTollSum = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)->where('status', '0')
                ->select('paytolls.*', 'paytoll__drivers.*')
                ->sum('price');

            $unpaid =  $unpaidChargesSum +  $unpaidTollSum;

            //-------------------------End Section--------------------------------------------------

            //----------------------Total Charges---------------------------------------------------

            $citycharges = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)
                ->select('cities.*', 'city__drivers.*')
                ->sum('price');

            $tollsCharges = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)
                ->select('paytolls.*', 'paytoll__drivers.*')
                ->sum('price');

            $totalCharges = $citycharges + $tollsCharges;

            //-------------------------------End Section-------------------------------------------

            //----------------------unpaid and paid ticket section------------------------------------------

            $unpaidTickets = Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '0');
            })->get();


            $unpaidTolls = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)->where('paytoll__drivers.status', '0')
                ->select('paytolls.*', 'drivers.name as user_name', 'paytoll__drivers.*')
                ->get();

            $unpaidCities = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)->where('city__drivers.status', '0')
                ->select('cities.*', 'drivers.name as user_name', 'city__drivers.*')
                ->get();


            $paidTickets = Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '1');
            })->get();


            $paidTolls = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)->where('paytoll__drivers.status', '1')
                ->select('paytolls.*', 'drivers.name as user_name', 'paytoll__drivers.*')
                ->get();

            $paidCities = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)->where('city__drivers.status', '1')
                ->select('cities.*', 'drivers.name as user_name', 'city__drivers.*')
                ->get();
            //-------------------------------------End paid and unpaid Section---------------------------------
           
            // return $paidTolls;
            $page = 'dash';
            return view('home', compact(
                'page',
                'tickets',
                'tolls',
                'cities',
                'charges',
                'unpaidTicket',
                'unpaidCharges',
                'totalCharges',
                'unpaid',
                'unpaidTickets',
                'unpaidTolls',
                'unpaidCities',
                'paidCities',
                'paidTolls',
                'paidTickets',
            ));
        } else {

            return view('profile.newUser');
        }
    }
}
