<?php

namespace App\Http\Controllers;

use App\Models\City;
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
        $unpaidTicketSum = Ticket::where('status', '0')->sum('price');
        $totalCharges = City::all()->sum('price');

        $page = 'dash';
        return view('home',compact('page','tickets','charges','unpaidTicket','unpaidCharges','totalCharges', 'unpaidChargesSum'));
    }
}
