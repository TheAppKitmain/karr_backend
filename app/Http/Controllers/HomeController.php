<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Paytoll;
use App\Models\Ticket;
use Illuminate\Http\Request;

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
        $tickets = Ticket::all();
        $charges = City::all()->count();
        $unpaidTicket = Ticket::where('status', '0')->get()->count();
        $unpaidCharges = City::where('status', '0')->get()->count();
        $unpaidChargesSum = City::where('status', '0')->sum('price');
        $unpaidTollSum = Paytoll::where('status', '0')->sum('price');
        $unpaid =  $unpaidChargesSum +  $unpaidTollSum;
        $citycharges = City::all()->sum('price');
        $tollsCharges = Paytoll::all()->sum('price'); 
        $totalCharges = $citycharges + $tollsCharges; 
        $tolls = Paytoll::all();
        foreach ($tolls as $toll) {
            $toll->selectedDays = json_decode($toll->days);
        }
        $cities = city::all();

        $page = 'dash';
        return view('home',compact('page','tickets','tolls','cities','charges','unpaidTicket','unpaidCharges','totalCharges', 'unpaid'));
    }
}
