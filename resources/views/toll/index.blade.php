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
            justify-content: space-between;
        }

        .main {
            background: #8C52FF !important;
            color: #FFF;
        }

        .payMultiple {
            border-radius: 10px;
            background: #8C52FF;
            padding: 20px 8px;
            color: var(--white, #FFF);
            height: fit-content;
            font-weight: 500;
            width: 150px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            font-size: 14px;

        }

        .notes {
            display: none;
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
                <div class="sort dropdown">
                    <p id="dropdown-toggle">Filter By<span class="caret"></span></p>
                    <div class="dropdown-content" id="dropdown-content" style="position: absolute; top: 100%;">
                        <a href="#" id="paid">Paid</a>
                        <a href="#" id="unpaid">Unpaid</a>
                    </div>
                </div>
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
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay Now</a>
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn main"
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn main"
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
                <div class="pay">
                    <a href="#" class="payMultiple" id="selectAllCheckboxItems">Pay multiple Tickets</a>

                </div>
                <div id="totalPriceDisplay" style="margin-top: 10px; font-size 14px; ">
                    Total Price: £ 0.00
                </div>

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
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td>Unpaid</td>
                                        <td>
                                            <a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay Now</a>
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td>Unpaid</td>
                                        <td><a class="btn main"
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td> Unpaid</td>
                                        <td><a class="btn main"
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
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn main"
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn main"
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
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn main"
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn main"
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70"
                                    viewBox="0 0 70 70" fill="none">
                                    <path
                                        d="M25.0335 35.0772C25.7627 34.5304 26.7652 34.5304 27.4944 35.0772L31.5265 38.1013L35.0715 35.4426L28.1641 23.5117V15.9875H39.2383C40.046 15.9875 40.7787 15.5132 41.1093 14.7763C41.44 14.0392 41.3071 13.1768 40.7702 12.5735L38.7023 10.2495L40.7702 7.92586C41.3072 7.32252 41.44 6.45996 41.1093 5.72305C40.7787 4.986 40.046 4.51172 39.2383 4.51172H28.1641V4.375C28.1641 3.24242 27.2459 2.32422 26.1133 2.32422C24.9807 2.32422 24.0625 3.24242 24.0625 4.375V23.5117L17.2002 35.3646L20.9826 38.1154L25.0335 35.0772Z"
                                        fill="#2D927E"></path>
                                    <path
                                        d="M32.757 42.3056C32.0277 42.8525 31.0253 42.8525 30.2961 42.3056L26.2639 39.2815L22.2318 42.3056C21.8675 42.5789 21.4345 42.7158 21.0014 42.7158C20.5782 42.7158 20.1549 42.5852 19.7952 42.3235L15.1342 38.9336L0.276036 64.5975C-0.0913271 65.232 -0.0918739 66.0142 0.274122 66.6494C0.640392 67.2846 1.3177 67.6758 2.05078 67.6758H53.684L37.141 39.0174L32.757 42.3056Z"
                                        fill="#F3D55B"></path>
                                    <path
                                        d="M69.6742 64.516L49.9867 33.891C49.5992 33.288 48.9285 32.9318 48.2081 32.9499C47.4916 32.9686 46.8368 33.3602 46.4811 33.9825L42.7448 40.5209L58.4199 67.6758H67.9492C68.6994 67.6758 69.3897 67.2661 69.7493 66.6077C70.1087 65.9493 70.08 65.147 69.6742 64.516Z"
                                        fill="#F3D55B"></path>
                                </svg>
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
