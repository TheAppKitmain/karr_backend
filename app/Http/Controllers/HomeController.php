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

            $tickets = DB::table('tickets')
            ->join('drivers', 'tickets.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select('tickets.*', 'drivers.name as driver', 'users.name as user_name')
            ->orderBy('tickets.id', 'desc')->get();
            
            $charges = City::all()->count();

            $unpaidTicket = Ticket::where('status', '0')->count();
            $unpaidCharges = DB::table('city__driver')->where('status', '0');

            $unpaidChargesSum = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->where('city__drivers.status', 0)
                ->sum('cities.price');

            $unpaidTollSum = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->where('paytoll__drivers.status', 0)
                ->sum('paytolls.price');

            $unpaid =  $unpaidChargesSum +  $unpaidTollSum;

            $citycharges = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->sum('cities.price');
            $tollsCharges =  DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->sum('paytolls.price');

            $totalCharges = $citycharges + $tollsCharges;

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

            // dd($cities);

            $page = 'dash';
            return view('home', compact('page', 'tickets', 'tolls', 'cities', 'charges', 'unpaidTicket', 'unpaidCharges', 'totalCharges', 'unpaid'));
        }


        //------------------------------- For Admin -------------------------------------------------

        elseif ($roles->contains('name', 'Admin')) {
            $tickets = Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->get();



            $tolls = DB::table('paytolls')
                ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
                ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)
                ->select('paytolls.*', 'drivers.name as user_name','paytoll__drivers.*')
                ->orderBy('paytolls.id', 'desc') ->limit(3) ->get();

            foreach ($tolls as $toll) {
                $toll->selectedDays = json_decode($toll->days);
            }

            $cities = DB::table('cities')
                ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
                ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
                ->where('drivers.user_id', $userId)
                ->select('cities.*','drivers.name as user_name', 'city__drivers.*')
                ->get();

            //  dd($cities);

            $charges = City::all()->count();
            $unpaidTicket =  Ticket::whereHas('driver.user', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', '0');
            })->count();

            $unpaidCharges = DB::table('city__drivers')->where('status', '0');

            $unpaidChargesSum =  DB::table('cities')
            ->join('city__drivers', 'cities.id', '=', 'city__drivers.city_id')
            ->join('drivers', 'city__drivers.driver_id', '=', 'drivers.id')
            ->where('drivers.user_id', $userId)->where('status', '0')
            ->select('cities.*', 'city__drivers.*')
            ->sum('price');


            $unpaidTollSum = DB::table('paytolls')
            ->join('paytoll__drivers', 'paytolls.id', '=', 'paytoll__drivers.paytoll_id')
            ->join('drivers', 'paytoll__drivers.driver_id', '=', 'drivers.id')
            ->where('drivers.user_id', $userId)->where('status' , '0')
            ->select('paytolls.*', 'paytoll__drivers.*')
            ->sum('price');

            $unpaid =  $unpaidChargesSum +  $unpaidTollSum;

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

            $page = 'dash';
            return view('home', compact('page', 'tickets', 'tolls', 'cities', 'charges', 'unpaidTicket', 'unpaidCharges', 'totalCharges', 'unpaid'));
        }
        else{
           
            return view('profile.newUser');
        
        }
    }
}
