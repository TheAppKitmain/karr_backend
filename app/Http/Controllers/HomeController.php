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
        if ($roles->contains('name', 'Super Admin')) {
           
            $tickets = Ticket::orderBy('id', 'desc')->take(3)->get();
            $charges = City::all()->count();

            $unpaidTicket = Ticket::where('status', '0')->get()->count();
            $unpaidCharges = DB::table('city_driver')->where('status', '0');

            $unpaidChargesSum = DB::table('cities')
                ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
                ->where('city_driver.status', 0)
                ->sum('cities.price');

            $unpaidTollSum = DB::table('paytolls')
                ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
                ->where('driver_paytoll.status', 0)
                ->sum('paytolls.price');

            $unpaid =  $unpaidChargesSum +  $unpaidTollSum;

            $citycharges = DB::table('cities')
                ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
                ->sum('cities.price');
            $tollsCharges =  DB::table('paytolls')
                ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
                ->sum('paytolls.price');

            $totalCharges = $citycharges + $tollsCharges;

            $tolls = DB::table('paytolls')
                ->join('driver_paytoll', 'paytolls.id', '=', 'driver_paytoll.paytoll_id')
                ->select('paytolls.*', 'driver_paytoll.*')->orderBy('id', 'desc')->take(3)->get();

    
            foreach ($tolls as $toll) {
                $toll->selectedDays = json_decode($toll->days);
            }
            $cities = DB::table('cities')
                ->join('city_driver', 'cities.id', '=', 'city_driver.city_id')
                ->select('cities.*', 'city_driver.*')->orderBy('id', 'desc')->take(3)->get();
    
            // dd($cities);
    
            $page = 'dash';
            return view('home', compact('page', 'tickets', 'tolls', 'cities', 'charges', 'unpaidTicket', 'unpaidCharges', 'totalCharges', 'unpaid'));
     
        } 
        
        
        //------------------------------- For Admin -------------------------------------------------
        
        elseif ($roles->contains('name', 'Admin')) {
            $tickets = Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->get();

            $tolls = Paytoll::whereHas('drivers.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->get();
            foreach ($tolls as $toll) {
                $toll->selectedDays = json_decode($toll->days);
            }

            // dd($tolls);
            $cities = City::whereHas('drivers.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->get();

            $charges = City::all()->count();
            $unpaidTicket =  Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '0');
            })->count();

            $unpaidCharges = DB::table('city_driver')->where('status', '0');

            $unpaidChargesSum = City::whereHas('drivers.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '0');
            })->sum('price');
            $unpaidTollSum = Paytoll::whereHas('drivers.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '0');
            })->sum('price');

            $unpaid =  $unpaidChargesSum +  $unpaidTollSum;

            $citycharges = City::whereHas('drivers.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->sum('price');

            $tollsCharges = Paytoll::whereHas('drivers.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->sum('price');

            $totalCharges = $citycharges + $tollsCharges;

            $page = 'dash';
            return view('home', compact('page', 'tickets', 'tolls', 'cities', 'charges', 'unpaidTicket', 'unpaidCharges', 'totalCharges', 'unpaid'));
        }
    }
}
