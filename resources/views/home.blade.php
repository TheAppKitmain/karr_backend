<?php
$ticketCount = $tickets->count();
$count = 1;
?>
@extends('layouts.app')

@section('content')
    <style>
        .home {
            float: left;
            margin: 5px;
            width: 150px;
            border-radius: 10px;
            height: 80px;
        }

        .homeText {
            top: 19px;
            margin-left: 1rem;
            color: #ffffff;
            left: 12px;
        }

        .homeText p {
            color: #ffffff;
            font-size: 13px
        }

        .homeText span {
            font-family: 'lato';
            font-weight: 700;
            font-size: 15px;

        }
        span{
            margin-top: 10px;
        }

        .scroll {
            display: block;
            overflow-x: auto;
        }

        table td {
            font-size: 13px;
        }
    </style>
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content" style="display:flex;">

                        <div class="home" style="background: #8C52FF;">
                            <div class="homeText">
                                <p>Total Tickets</p>
                                <span>{{ $ticketCount }}</span>
                            </div>

                        </div>
                        <div class="home" style="background: #5A9FD6; ">
                            <div class="homeText">
                                <p>Unpaid Tickets</p>
                                <span>{{ $unpaidTicket }}</span>
                            </div>

                        </div>
                        <div class="home" style="background:  #FFB400;">
                            <div class="homeText">
                                <p>Total Charges</p>
                                <span>£{{ number_format($totalCharges, 2) }}</span>
                            </div>

                        </div>
                        <div class="home" style="background:  #FF6F73;">
                            <div class="homeText">
                                <p>Unpaid Charges</p>
                                <span>£{{ number_format($unpaid, 2) }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="create-services-screen" style="margin-top:10px">
        <div class="row create-services-screen-left">
            <div class="col-lg-12">
                <div class="for-our-services">
                    <h3>Recent Tickets & Charges</h3>
                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" class="search-query form-control" placeholder="Search">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 border-both">
                <div class="scroll">
                    <table class="table" id="AllTable">
                        <thead>
                            <tr style="background-color: #F8F8FA">
                                <!-- Define the table headers -->
                                <th>PCN</th>
                                <th>Name</th>
                                <th>Time</th>
                                <th>Type</th>
                                @can('admin-ticket')
                                    <th>Business </th>
                                @endcan
                                <th>Issued by</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $key => $ticket)
                                <?php $name = 'tk'; ?>
                                <tr>
                                    <td>{{ $ticket->pcn }}</td>
                                    @can('admin-ticket')
                                        <td>{{ $ticket->driver }}</td>
                                    @endcan
                                    @can('toll-pay')
                                    <td>{{ $ticket->driver->name }}</td>
                                    @endcan
                                    <td>{{ $ticket->date }}</td>
                                    <td> Ticket </td>
                                    @can('admin-ticket')
                                        <td>{{ $ticket->user_name }}</td>
                                    @endcan

                                    <td>{{ $ticket->ticket_issuer }}</td>
                                    <td>£ {{ number_format($ticket->price, 2) }}</td>
                                    @can('toll-pay')
                                        @if ($ticket->status == '1')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                            </td>
                                        @elseif ($ticket->status == '0')
                                            <td><a class="btn btn-danger" href="{{ route('ticket.pay', $ticket->id) }}">Pay
                                                    Now</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                                    @can('admin-ticket')
                                        @if ($ticket->status == '1')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('admin.unpaid', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Mark
                                                    unpaid</a>
                                            </td>
                                        @elseif ($ticket->status == '0')
                                            <td><a class="btn btn-danger"
                                                    href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                                </tr>
                            @endforeach

                            @foreach ($tolls as $toll)
                                <?php $name = 'tl'; ?>
                                <tr>
                                    <td></td>
                                    <td>{{ $toll->name }}</td>
                                    <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                    <td> Tolls </td>
                                    @can('admin-ticket')
                                        <td>{{ $toll->user_name }}</td>
                                    @endcan
                                    <td></td>
                                    <td>£ {{ number_format($toll->price, 2) }}</td>

                                    @can('toll-pay')
                                        @if ($toll->tollDrivers->first()->status == 1)
                                            <td><a class="btn btn-success"
                                                    href="{{ route('toll.pay', ['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id]) }}">Paid</a>
                                            </td>
                                        @elseif ($toll->tollDrivers->first()->status == 0)
                                            <td><a class="btn btn-danger"
                                                    href="{{ route('toll.pay', ['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id]) }}">
                                                    Pay Now</a>
                                            </td>
                                        @elseif ($toll->tollDrivers->first()->status == 2)
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('toll.pay', ['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id]) }}">
                                                    Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                                    @can('admin-ticket')
                                        @if ($toll->status == '1')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('admin.unpaid', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Mark
                                                    unpaid</a>
                                            </td>
                                        @elseif ($toll->status == '0')
                                            <td><a class="btn btn-danger"
                                                    href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @elseif ($toll->status == '2')
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan

                                </tr>
                            @endforeach

                            @foreach ($cities as $city)
                                <?php $name = 'ct'; ?>
                                <tr>
                                    <td></td>
                                    <td>{{ $city->city }}</td>
                                    <td>{{ $city->date }}</td>
                                    <td> City Charge </td>
                                    @can('admin-ticket')
                                        <td>{{ $city->user_name }}</td>
                                    @endcan
                                    <td></td>
                                    <td>£ {{ number_format($city->price, 2) }}</td>
                                    @can('toll-pay')
                                        @if ($city->cityDrivers->first()->status == 1)
                                            <td><a class="btn btn-success"
                                                    href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Paid</a>
                                            </td>
                                        @elseif ($city->cityDrivers->first()->status == 0)
                                            <td><a class="btn btn-danger"
                                                    href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                                    @can('admin-ticket')
                                        @if ($city->status == '1')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('admin.unpaid', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Mark
                                                    unpaid</a>
                                            </td>
                                        @elseif ($city->status == 0)
                                            <td><a
                                                    class="btn btn-danger"href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


    </section>
@endsection
