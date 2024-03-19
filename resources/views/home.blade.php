<?php

$ticketCount = $tickets->count();
$count = 1;
?>
@extends('layouts.app')

@section('content')
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <style>
        .home {
            float: left;
            margin: 5px;
            width: 150px;
            border-radius: 10px;
            height: 80px;
        }

        .homeText {
            /* margin-top: 5px; */
            margin-left: 1rem;
            color: #ffffff;
            font-family: 'Futura';

        }

        .homeText a {
            color: #ffffff;
            background: none;
            font-size: 13px;
            margin-left: -17px;
            text-align: center;
        }

        .homeText p {
            color: #ffffff;
            background: none;
            font-size: 13px
        }

        .homeText span {
            font-family: 'Futura';
            font-weight: 700;
            font-size: 15px;
            text-align: center;
        }

        span {
            margin-top: 10px;
        }

        .scroll {
            display: block;
            overflow-x: auto;
        }

        table td {
            font-size: 14px;
        }

        .main {
            background: #8C52FF;
            color: #ffffff;
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

        .create-services-screen .border-both:last-child {
            padding: 10px 0px;
        }

        .btn-dark {
            color: #fff;
            background-color: #000;

        }
    </style>
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content" style="display:flex;">

                        <div class="home" style="background: #8C52FF;">
                            <div class="homeText" style="">
                                <a @if (Auth::user()->roles->contains('name', 'Super Admin')) href="{{ route('admin.tickets') }}"
                                    @else
                                        href="{{ route('tickets') }}" @endif
                                    class="custom">
                                    Total Tickets
                                </a>
                                <span>{{ $ticketCount }}</span>
                            </div>


                        </div>
                        <div class="home" style="background: #5A9FD6; ">
                            <div class="homeText">
                                <a @if (Auth::user()->roles->contains('name', 'Super Admin')) href="{{ route('admin.tickets') }}"
                                    @else
                                        href="{{ route('tickets') }}" @endif
                                    class="custom">Unpaid Tickets</a>
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
                <div class="for-our-services" style="margin-bottom: 10px;">
                    <h3>Recent Tickets & Charges</h3>

                </div>
            </div>
            <div class="col-lg-12 border-both">
                <div class="for-our-services">
                    <div class="sort dropdown">
                        <p id="dropdown-toggle">Filter By<span class="caret"></span></p>
                        <div class="dropdown-content" id="dropdown-content" style="position: absolute; top: 100%;">
                            <a href="#" id="ticket">Parking Fines</a>
                            <a href="#" id="toll">Tolls</a>
                            <a href="#" id="city">City Charge</a>
                        </div>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="scroll" id="AllTable">
                    <table class="table" id="demo">
                        @if ($tickets->isEmpty() && $tolls->isEmpty() && $cities->isEmpty())
                            <center>
                                <h4>You have no Tickets or Charges</h4>
                            </center>
                        @else
                            <thead>
                                <tr style="background-color: #F8F8FA">
                                    <!-- Define the table headers -->
                                    <th>PCN</th>
                                    <th>Name</th>
                                    <th>Date</th>
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
                                                <td><a class="btn btn-dark"
                                                        href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                                </td>
                                            @elseif ($ticket->status == '0')
                                                <td><a class="btn btn-success"
                                                        href="{{ route('ticket.pay', $ticket->id) }}">Pay
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
                                                <td><a class="btn btn-dark"
                                                        href="{{ route('admin.unpaid', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Paid</a>
                                                </td>
                                            @elseif ($ticket->status == '0')
                                                <td><a class="btn btn-success"
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
                                        <td>{{ $toll->user_name }}</td>
                                        <td>{{ $toll->date }}</td>
                                        <td> Tolls </td>
                                        @can('admin-ticket')
                                            <td>{{ $toll->user_name }}</td>
                                        @endcan
                                        <td></td>
                                        <td>£ {{ number_format($toll->price, 2) }}</td>

                                        @can('toll-pay')
                                            @if ($toll->status == 1)
                                                <td><a class="btn btn-dark"
                                                        href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                                </td>
                                            @elseif ($toll->status == 0)
                                                <td><a class="btn btn-success"
                                                        href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">
                                                        Pay Now</a>
                                                </td>
                                            @elseif ($toll->status == 2)
                                                <td><a class="btn btn-primary"
                                                        href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">
                                                        Disputed</a>
                                                </td>
                                            @endif
                                        @endcan
                                        @can('admin-ticket')
                                            @if ($toll->status == '1')
                                                <td><a class="btn btn-dark"
                                                        href="{{ route('admin.unpaid', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Paid</a>
                                                </td>
                                            @elseif ($toll->status == '0')
                                                <td><a class="btn btn-success"
                                                        href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Pay
                                                        Now</a>
                                                </td>
                                            @elseif ($toll->status == '2')
                                                <td><a class="btn btn-primary"
                                                        href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Disputed</a>
                                                </td>
                                            @endif
                                        @endcan

                                    </tr>
                                @endforeach

                                @foreach ($cities as $city)
                                    <?php $name = 'ct'; ?>
                                    <tr>
                                        <td></td>
                                        <td>{{ $city->user_name }}</td>
                                        <td>{{ $city->date }}</td>
                                        <td> City Charge </td>
                                        @can('admin-ticket')
                                            <td>{{ $city->user_name }}</td>
                                        @endcan
                                        <td></td>
                                        <td>£ {{ number_format($city->price, 2) }}</td>
                                        @can('toll-pay')
                                            @if ($city->status == 1)
                                                <td><a class="btn btn-dark"
                                                        href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                                </td>
                                            @elseif ($city->status == 0)
                                                <td><a class="btn btn-success"
                                                        href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Pay
                                                        Now</a>
                                                </td>
                                            @else
                                                <td><a class="btn btn-primary"
                                                        href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Disputed</a>
                                                </td>
                                            @endif
                                        @endcan
                                        @can('admin-ticket')
                                            @if ($city->status == '1')
                                                <td><a class="btn btn-dark"
                                                        href="{{ route('admin.unpaid', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Paid</a>
                                                </td>
                                            @elseif ($city->status == 0)
                                                <td><a class="btn btn-success"
                                                        href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Pay
                                                        Now</a>
                                                </td>
                                            @else
                                                <td><a class="btn btn-primary"
                                                        href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Disputed</a>
                                                </td>
                                            @endif
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>

                <div class="scroll" id="ticketsTable" style="display: none;">
                    <table class="table" id="demo">
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
                                    @can('admin-ticket')
                                        <td>{{ $ticket->driver }}</td>
                                    @endcan
                                    @can('toll-pay')
                                        <td>{{ $ticket->driver->name }}</td>
                                    @endcan
                                    <td>{{ $ticket->date }}</td>
                                    <td>{{ $ticket->pcn }}</td>
                                    <td>{{ $ticket->ticket_issuer }}</td>
                                    <td>Ticket</td>
                                    <td>£ {{ number_format($ticket->price, 2) }}</td>
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
                                    @can('admin-ticket')
                                        @if ($ticket->status == '1')
                                            <td><a class="btn btn-dark"
                                                    href="{{ route('admin.unpaid', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Paid</a>
                                            </td>
                                        @elseif ($ticket->status == '0')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="scroll" id="cityTable" style="display: none;">
                    <table class="table" id="demo">
                        <thread>
                            <h4 id="cityHeading" style="display: none;">City Charges</h4>
                            <tr style="background-color:#F8F8FA;">
                                <th>Check</th>
                                <th>City Name</th>
                                <th>Name</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Type</th>
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
                                    <td>£ {{ number_format($city->price, 2) }}</td>
                                    <td>Charges</td>
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
                                    @can('admin-ticket')
                                        @if ($city->status == '1')
                                            <td><a class="btn btn-dark"
                                                    href="{{ route('admin.unpaid', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Paid</a>
                                            </td>
                                        @elseif ($city->status == 0)
                                            <td><a class="btn btn-success"
                                                    href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @else
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="scroll" id="tollsTable" style="display: none;">
                    <table class="table" id="demo">
                        <thread>
                            <h4 id="tollsHeading" style="display: none;">Tolls</h4> {{-- Initially hidden --}}
                            <tr style="background-color:#F8F8FA;">
                                <th>Check</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Price</th>
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
                                    @can('admin-ticket')
                                        @if ($toll->status == '1')
                                            <td><a class="btn btn-dark"
                                                    href="{{ route('admin.unpaid', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Paid</a>
                                            </td>
                                        @elseif ($toll->status == '0')
                                            <td><a class="btn btn-success"
                                                    href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Pay
                                                    Now</a>
                                            </td>
                                        @elseif ($toll->status == '2')
                                            <td><a class="btn btn-primary"
                                                    href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Disputed</a>
                                            </td>
                                        @endif
                                    @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </section>
    <script>
        $(document).ready(function() {
            $('#demo').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
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
    <script>
        $("#toll").click(function() {
            $("#tollsTable").show();
            $("#AllTable").hide();
            $("#cityTable").hide();
            $("#ticketsTable").hide();
        });

        $("#city").click(function() {
            $("#cityTable").show();
            $("#tollsTable").hide();
            $("#AllTable").hide();
            $("#ticketsTable").hide();
        });
        $("#ticket").click(function() {
            $("#ticketsTable").show();
            $("#cityTable").hide();
            $("#tollsTable").hide();
            $("#AllTable").hide();
        });
    </script>

@endsection
