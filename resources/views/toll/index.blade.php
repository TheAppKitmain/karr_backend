<?php
$page = 'tolls';
?>
@extends('layouts.app')
@section('content')
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style>
        .home {
            float: left;
            margin: 5px;
            width: 150px;
            border-radius: 10px;
            height: 50px;
            background: #FBFBFB;
        }

        .homeChange {
            background: #8C52FF;
            color: white;
        }

        .homeCity {
            background: #FFB400;
            color: white;
        }

        .homeToll {
            background: #5A9FD6;
            color: white;
        }

        .scroll {
            display: block;
            overflow-x: auto;
        }

        .sort {
            width: 180px;
            height: 35px;
            background-color: #F8F8FA;
            border: 1px solid #F8F8FA;
            border-radius: 10px;
        }

        .sort p {
            margin-top: 5px;
            font-family: 'lato';
            font-weight: 500;
        }

        .sort span {
            margin-left: 100px;
        }

        .dropdown {
            display: flex;
            /* align-items: flex-end;
                                                                                                                                                                                                                                                                                                        align-content: space-around; */
            justify-content: flex-end;

        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9 !important;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            padding: 12px 16px;
            /* display: block; */
            text-align: left;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background-color: #ddd !important;
        }

        .welcome-inner-content {
            display: flex;
            justify-content: space-between;
        }

        .pay {
            display: flex;
            margin-bottom: 10px;
        }

        .main {
            background: #8C52FF !important;
            color: #FFF;
        }

        .payMultiple {
            padding: 10px;
            margin-left: 10px;
            background-color: #8C52FF;
            color: #FFF;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .notes {
            display: none;
        }

        .btn-dark {
            color: #fff;
            background-color: #000;

        }

        .pay {
            display: flex;
            margin-bottom: 10px;
        }

        .for-our-services a {
            padding: 10px;
            font-size: 14px;
        }
    </style>
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content" style="display:flex;  justify-content: start;">
                        <button href="#" id="ticket" class="home">
                            Parking Fines
                        </button>
                        <button id="toll" class="home">
                            Toll
                        </button>
                        <button id="charge" class="home">
                            Charges
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="create-services-screen" style="margin-top:10px ">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <a href="#" class="payMultiple" id="selectAllCheckboxItems">Pay Multiple Tickets</a>
                <div class="sort dropdown">
                    <p id="dropdown-toggle">Filter By<span class="caret"></span></p>
                    <div class="dropdown-content" id="dropdown-content" style="position: absolute; top: 100%;">
                        <a href="#" id="paid">Paid</a>
                        <a href="#" id="unpaid">Unpaid</a>
                    </div>
                </div>
            </div>
            <div id="totalPriceDisplay" style="font-size 14px; margin-bottom:10px; margin-left:10px; margin-top:-20px">
                Total Price: £0.00
            </div>

            <div class="scroll" id="AllTable">
                <table class="table" id="table">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th><input type="checkbox" id="select-all" /> Select All</th>
                            <th>Name</th>
                            <th>PCN</th>
                            <th>Date</th>
                            <th>Issued by</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tickets" name="ticket_ids[]"
                                        data-price="{{ $ticket->price }}" value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ number_format($ticket->price, 2) }}</td>
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-dark" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($tolls as $toll)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tolls" name="toll_ids[]"
                                        data-price="{{ $toll->price }}" value="{{ $toll->pd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $toll->user_name }}</td>
                                <td></td>
                                <td>{{ $toll->date }}</td>
                                <td></td>
                                <td>Tolls</td>
                                <td>£{{ number_format($toll->price, 2) }}</td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td><a class="btn btn-dark"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($cities as $city)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="city" name="city_ids[]"
                                        data-price="{{ $city->price }}" value="{{ $city->cd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $city->user_name }}</td>
                                <td></td>
                                <td>{{ $city->date }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£ {{ number_format($city->price, 2) }}</td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td><a class="btn btn-dark"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Pay
                                                Now</a></td>
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <div class="scroll">
                <table class="table" id="ticketsTable" style="display: none;">
                    <thread>
                        <h4 id="ticketsHeading" style="display:none; ">Tickets</h4>
                        <tr style="background-color: #F8F8FA">
                            <th>Check</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>PCN</th>
                            <th>Ticket Issuer</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Status</th>
                            @can('ticket-pay')
                                <th>Pay</th>
                            @endcan
                        </tr>
                    </thread>
                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" name="" id="" value="{{ $ticket->id }}">
                                </td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£ {{ number_format($ticket->price, 2) }}</td>
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td>Paid</td>
                                        <td><a class="btn btn-dark" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td>Unpaid</td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
                                        <td>Disputed</td>
                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="scroll">
                <table class="table" id="cityTable" style="display: none;">
                    <thread>
                        <h4 id="cityHeading" style="display: none;">City Charges</h4>
                        <tr style="background-color:#F8F8FA;">
                            <th>Check</th>
                            <th>City Name</th>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th>Notes</th>
                            <th>Status</th>
                            @can('charges-pay')
                                <th>Pay</th>
                            @endcan
                        </tr>
                    </thread>
                    <tbody>
                        @foreach ($cities as $key => $city)
                            <tr>
                                <td><input type="checkbox" id="vehicle1" id="check" name="ids[]"
                                        value="{{ $city->cd }}"></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->user_name }}</td>
                                <td>{{ $city->date }}</td>
                                <td>£{{ number_format($city->price, 2) }}</td>
                                <td>Charges</td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td>Paid</td>
                                        <td><a class="btn btn-dark"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td>Unpaid</td>
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Pay
                                                Now</a></td>
                                    @elseif ($city->status == 2)
                                        <td>Disputed</td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="scroll">
                <table class="table" id="tollsTable" style="display: none;">
                    <thread>
                        <h4 id="tollsHeading" style="display: none;">Tolls</h4> {{-- Initially hidden --}}
                        <tr style="background-color:#F8F8FA;">
                            <th>Check</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Status</th>
                            @can('toll-pay')
                                <th>Pay</th>
                            @endcan
                        </tr>
                    </thread>
                    <tbody>
                        @foreach ($tolls as $key => $toll)
                            <tr>
                                <td><input type="checkbox" id="vehicle1" id="check" name="ids[]"
                                        value="{{ $toll->id }}"></td>
                                <td>{{ $toll->user_name }}</td>
                                <td>
                                    {{ $toll->date }}
                                </td>
                                <td>Tolls</td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td> Paid </td>
                                        <td><a class="btn btn-dark"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td> Unpaid</td>
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == 2)
                                        <td> Disputed </td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="scroll">
                <table class="table" id="unpaidTable" style="display: none">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th><input type="checkbox" id="select-all" /> Select All</th>
                            <th>Name</th>
                            <th>PCN</th>
                            <th>Date</th>
                            <th>Issued by</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unpaidTickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tickets"
                                        name="ticket_ids[]" value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ number_format($ticket->price, 2) }}</td>
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-dark" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($unpaidTolls as $toll)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tolls" name="toll_ids[]"
                                        value="{{ $toll->pd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $toll->user_name }}</td>
                                <td></td>
                                <td>{{ $toll->date }}</td>
                                <td></td>
                                <td>Tolls</td>
                                <td>£{{ number_format($toll->price, 2) }}</td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td><a class="btn btn-dark"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($unpaidCities as $city)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="city" name="city_ids[]"
                                        value="{{ $city->cd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $city->user_name }}</td>
                                <td></td>
                                <td>{{ $city->date }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£{{ number_format($city->price, 2) }}</td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td><a class="btn btn-dark"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Pay
                                                Now</a></td>
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="scroll">
                <table class="table" id="paidTable" style="display: none">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th><input type="checkbox" id="select-all" /> Select All</th>
                            <th>Name</th>
                            <th>PCN</th>
                            <th>Date</th>
                            <th>Issued by</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paidTickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tickets"
                                        name="ticket_ids[]" value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ number_format($ticket->price, 2) }}</td>
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-dark" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($paidTolls as $toll)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tolls" name="toll_ids[]"
                                        value="{{ $toll->pd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $toll->user_name }}</td>
                                <td></td>
                                <td>{{ $toll->date }}</td>
                                <td></td>
                                <td>Tolls</td>
                                <td>£{{ number_format($toll->price, 2) }}</td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td><a class="btn btn-dark"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($paidCities as $city)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="city" name="city_ids[]"
                                        value="{{ $city->cd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $city->user_name }}</td>
                                <td></td>
                                <td>{{ $city->date }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£{{ number_format($city->price, 2) }}</td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes" data-toggle="modal"
                                                data-target="#myModal">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td><a class="btn btn-dark"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Pay
                                                Now</a></td>
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade create_success_property" id="myModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <div class="modal-header">
                            <div class="header_inner">
                                <img src="{{ asset('assets/dist/img/logo_1.svg') }}" alt="">
                            </div>
                        </div>
                        <h4 class="modal-title" id="myModalLabel"><strong>Notes</strong></h4>
                    </div>
                    <div class="modal-body">
                        <!-- Notes content will be displayed here -->
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Script to hide tables --}}
    <script>
        $(document).ready(function() {
            $("#toll").click(function() {
                $(this).addClass('homeToll');
                $("#ticket").removeClass('homeChange');
                $("#charge").removeClass('homeCity');
                $("#tollsTable").show();
                $("#tollsHeading").show();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#unpaidTable").hide();
                $("#paidTable").hide();
                $("#AllTable").hide();
                $("#selectAllCheckboxItems").hide();
                $("#totalPriceDisplay").hide();
            });

            $("#ticket").click(function() {
                $(this).addClass('homeChange');
                $("#toll").removeClass('homeToll');
                $("#charge").removeClass('homeCity');
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").show();
                $("#ticketsTable").show();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#AllTable").hide();
                $("#unpaidTable").hide();
                $("#paidTable").hide();
                $("#selectAllCheckboxItems").hide();
                $("#totalPriceDisplay").hide();
            });

            $("#charge").click(function() {
                $(this).addClass('homeCity');
                $("#toll").removeClass('homeToll');
                $("#ticket").removeClass('homeChange');
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").show();
                $("#cityHeading").show();
                $("#AllTable").hide();
                $("#unpaidTable").hide();
                $("#paidTable").hide();
                $("#selectAllCheckboxItems").hide();
                $("#totalPriceDisplay").hide();
            });

            $("#unpaid").click(function() {
                $("#unpaidTable").show();
                $("#paidTable").hide();
                $("#AllTable").hide();
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#selectAllCheckboxItems").hide();

            });

            $("#paid").click(function() {
                $("#paidTable").show();
                $("#unpaidTable").hide();
                $("#AllTable").hide();
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#selectAllCheckboxItems").hide();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    {{-- Script for check box --}}
    <script>
        $(document).ready(function() {
            // When the "Pay multiple Tickets" anchor tag is clicked
            $('#selectAllCheckboxItems').click(function(event) {
                event.preventDefault(); // Prevent the default link behavior

                var selectedIds = {};

                // Iterate through all checkboxes with the "table-checkbox" class
                $('.table-checkbox:checked').each(function() {
                    var table = $(this).data('table');
                    var id = $(this).val();

                    // Add the ID to the corresponding table's array
                    if (!selectedIds[table]) {
                        selectedIds[table] = [];
                    }
                    selectedIds[table].push(id);
                });

                if (Object.keys(selectedIds).length > 0) {
                    // Convert the selectedIds object into a JSON string and encode it
                    var encodedIds = encodeURIComponent(JSON.stringify(selectedIds));

                    // Construct the URL with selected IDs as a query parameter
                    var url = "{{ route('bulk') }}?ids=" + encodedIds;

                    // Redirect to the constructed URL
                    window.location.href = url;
                } else {
                    // Handle the case when no items are selected
                    alert('No items are selected.');
                }
            });
            var dropdownToggle = document.getElementById("dropdown-toggle");
            var dropdownContent = document.getElementById("dropdown-content");

            // Add a click event listener to the toggle button
            dropdownToggle.addEventListener("click", function() {
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });

            // Close the dropdown if the user clicks outside of it
            window.addEventListener("click", function(event) {
                if (event.target !== dropdownToggle && event.target !== dropdownContent) {
                    dropdownContent.style.display = "none";
                }
            });
        });
    </script>
    {{-- Script for total price --}}
    <script>
        $(document).ready(function() {
            var totalPrice = 0.00;

            // Attach a change event handler to the checkboxes
            $('.table-checkbox').on('change', function() {
                var isChecked = $(this).prop('checked');
                var price = parseFloat($(this).data('price'));

                // Update the total price based on whether the checkbox is checked or unchecked
                if (isChecked) {
                    totalPrice += price;
                } else {
                    totalPrice -= price;
                }

                // Update the displayed total price
                $('#totalPriceDisplay').text('Total Price: £ ' + totalPrice.toFixed(2));
            });
            $('#select-all').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });
        });
    </script>

    {{-- Script for Notes --}}
    <script>
        $('#AllTable').on('click', '.toggle-notes', function(e) {
            e.preventDefault();
            var notes = $(this).closest('.notes-container').find('.notes').text();
            $('.modal-body').text(notes);
        });
        $('#unpaidTable').on('click', '.toggle-notes', function(e) {
            e.preventDefault();
            var notes = $(this).closest('.notes-container').find('.notes').text();
            $('.modal-body').text(notes);
        });
        $('#paidTable').on('click', '.toggle-notes', function(e) {
            e.preventDefault();
            var notes = $(this).closest('.notes-container').find('.notes').text();
            $('.modal-body').text(notes);
        });
        $('#ticketsTable').on('click', '.toggle-notes', function(e) {
            e.preventDefault();
            var notes = $(this).closest('.notes-container').find('.notes').text();
            $('.modal-body').text(notes);
        });
        $('#tollsTable').on('click', '.toggle-notes', function(e) {
            e.preventDefault();
            var notes = $(this).closest('.notes-container').find('.notes').text();
            $('.modal-body').text(notes);
        });
        $('#cityTable').on('click', '.toggle-notes', function(e) {
            e.preventDefault();
            var notes = $(this).closest('.notes-container').find('.notes').text();
            $('.modal-body').text(notes);
        });
    </script>
@endsection
