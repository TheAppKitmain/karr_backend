<?php
$page = 'user';
$ticketCount = $ticketData->count() + $tollData->count() + $cityData->count();

?>
@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
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
            font-size: 17px;

        }

        .scroll {
            display: block;
            overflow-x: auto;
        }
    </style>
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="welcome-inner-content" style="display:flex;">

                <div class="home" style="background: #8C52FF;">
                    <div class="homeText">
                        <p>Total Charges</p>
                        <span>{{ $ticketCount }}</span>
                    </div>

                </div>
                <div class="home" style="background: #5A9FD6; ">
                    <div class="homeText">
                        <p>Unpaid Charges</p>
                        <span>{{ $unpaidTickets }}</span>
                    </div>

                </div>
                <div class="home" style="background:  #FFB400;">
                    <div class="homeText">
                        <p>Unpaid Amount</p>
                        <span>£{{ number_format($unpaidCharges, 2) }}</span>
                    </div>

                </div>
                <div class="home" style="background:  #FF6F73;">
                    <div class="homeText">
                        <p>Total Amount</p>
                        <span>£{{ number_format($totalCharges, 2) }}</span>
                    </div>
                </div>

            </div>
            <div class="for-our-services">
                {{-- <h3>Details</h3> --}}
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Ticket Data -->
                        <div class="card mb-4">
                            <div class="card-header" style="margin-bottom: 10px">
                                <h4><strong>Ticket's Submitted by Driver</strong></h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>Driver</th>
                                            <th>Tickets</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticketData as $ticket)
                                            <tr>
                                                <td>{{ $ticket->driver->name }}</td>
                                                <td>{{ $ticket->pcn }}</td>
                                                <td>£ {{ number_format($ticket->price, 2) }}</td>
                                                <td>
                                                    @if ($ticket->status == 0)
                                                        <h4><span class="label label-default">Unpaid</span></h4>
                                                    @elseif ($ticket->status == 1)
                                                        <h4><span class="label label-success">Paid</span></h4>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Toll Data -->
                        <div class="card mb-4">
                            <div class="card-header" style="margin-bottom: 10px">
                                <h4><strong> Tolls </strong></h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="Tolltable">
                                    <thead>
                                        <tr>
                                            <th>Driver</th>
                                            <th>Toll</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tollData as $toll)
                                            <tr>
                                                <td>{{ $toll->user_name }}</td>
                                                <td>{{ $toll->name }}</td>
                                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                                <td>
                                                    @if ($toll->status == 0)
                                                        <h4><span class="label label-default">Unpaid</span></h4>
                                                    @elseif ($toll->status == 1)
                                                        <h4><span class="label label-success">Paid</span></h4>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- City Data -->
                        <div class="card mb-4">
                            <div class="card-header" style="margin-bottom: 10px">
                                <h4><strong>City Charges</strong></h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="Citytable">
                                    <thead>
                                        <tr>
                                            <th>Driver</th>
                                            <th>City Charge</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cityData as $city)
                                            <tr>
                                                <td>{{ $city->user_name }}</td>
                                                <td>{{ $city->area }}</td>
                                                <td>£ {{ number_format($city->price, 2) }}</td>
                                                <td>
                                                    @if ($city->status == 0)
                                                        <h4><span class="label label-default">Unpaid</span></h4>
                                                    @elseif ($city->status == 1)
                                                        <h4><span class="label label-success">Paid</span></h4>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Bank Data -->
                        <div class="card mb-4">
                            <div class="card-header" style="margin-bottom: 10px">
                                <h4><strong>Card on file</strong></h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="Cardtable" style="margin-bottom: 20px">
                                    <thead>
                                        <tr>
                                            <th>Card </th>
                                            <th>Card Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bank as $card)
                                            <tr>
                                                <td>{{ $card->name }}</td>
                                                <td>{{ str_repeat('*', strlen($card->card) - 4) . substr($card->card, -4) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
        $(document).ready(function() {
            $('#Tolltable').DataTable();
        });
        $(document).ready(function() {
            $('#Citytable').DataTable();
        });
        $(document).ready(function() {
            $('#Cardtable').DataTable();
        });
    </script>
@endsection
