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
            width: 170px;
            border-radius: 10px;
            height: 100px;
        }

        .homeText {
            top: 19px;
            margin-left: 1rem;
            color: #ffffff;
            left: 12px;
        }

        .homeText p {
            color: #ffffff;
            font-size: 15px
        }

        .homeText span {
            font-family: lato;
            font-weight: 700;
            font-size: 20px;

        }

        .scroll {
            display: block;
            overflow-x: auto;
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
                                <span>£{{ $totalCharges }}</span>
                            </div>

                        </div>
                        <div class="home" style="background:  #FF6F73;">
                            <div class="homeText">
                                <p>Unpaid Charges</p>
                                <span>£{{ $unpaid }}</span>
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
                    @can('toll-pay')
                        <table class="table" id="AllTable">
                            <thead>
                                <tr style="background-color: #F8F8FA">
                                    <!-- Define the table headers -->
                                    <th>No.</th>
                                    <th>PCN</th>
                                    <th>Name</th>
                                    <th>Time</th>
                                    <th>Issued by</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $key => $ticket)
                                    <tr>
                                        <th>{{ $count++ }}</th>
                                        <td>{{ $ticket->pcn }}</td>
                                        <td>{{ $ticket->driver->name }}</td>
                                        <td>{{ $ticket->date }}</td>
                                        <td>{{ $ticket->ticket_issuer }}</td>
                                        <td>{{ $ticket->price }}</td>
                                        @can('toll-pay')
                                            @if ($ticket->status == '1')
                                                <td><a class="btn btn-success"
                                                        href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                                </td>
                                            @elseif ($ticket->status == '0')
                                                <td><a class="btn btn-danger" href="{{ route('ticket.pay', $ticket->id) }}">Pay</a>
                                                </td>
                                            @else
                                                <td><a class="btn btn-primary"
                                                        href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                                </td>
                                            @endif
                                        @endcan
                                    </tr>
                                @endforeach

                                @foreach ($tolls as $toll)
                                    <tr>
                                        <th>{{ $count++ }}</th>
                                        <td></td>
                                        <td>{{ $toll->name }}</td>
                                        <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                        <td></td>
                                        <td>{{ $toll->price }}</td>
                                        @can('toll-pay')
                                            @if ($toll->status == '1')
                                                <td><a class="btn btn-success" href="{{ route('toll.pay', $toll->id) }}">Paid</a>
                                                </td>
                                            @elseif ($toll->status == '0')
                                                <td><a class="btn btn-danger" href="{{ route('toll.pay', $toll->id) }}">Pay</a>
                                                </td>
                                            @else
                                                <td><a class="btn btn-primary"
                                                        href="{{ route('toll.pay', $ticket->id) }}">Disputed</a>
                                                </td>
                                            @endif
                                        @endcan
                                    </tr>
                                @endforeach

                                @foreach ($cities as $city)
                                    <tr>
                                        <th>{{ $count++ }}</th>
                                        <td></td>
                                        <td>{{ $city->city }}</td>
                                        <td>{{ $city->time }}</td>
                                        <td></td>
                                        <td>{{ $city->price }}</td>
                                        @if ($city->status == '1')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('charges.pay', $city->id) }}">Paid</a>
                                            </td>
                                        @elseif ($city->status == 0)
                                            <td><a class="btn btn-danger" href="{{ route('charges.pay', $city->id) }}">Pay</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('charges.pay', $city->id) }}">Disputed</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endcan
                </div>
            </div>


    </section>
@endsection
