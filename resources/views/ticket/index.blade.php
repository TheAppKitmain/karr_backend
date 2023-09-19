<?php
$page = 'ticket';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@extends('layouts.app')
@section('content')
<style>
    .sort{
        width: 180px;
        height: 35px;
        background-color: #F8F8FA;
        border:1px solid #F8F8FA;
        border-radius: 10px;

    }
    .sort p{
        margin-left: 10px;
        font-size: 12px ; 
        font-family: 'lato';
        font-weight: 500;
    } 
    .sort span{
        margin-left: 100px;
    }
    .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9 !important;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
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
</style>
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <div class="sort dropdown">
                    <p>Sort By<span class="caret"></span></p>
                    <div class="dropdown-content">
                        <a href="#" id="showTicketsTable">Tickets</a>
                        <a href="#" id="showCityTable">Charges</a>
                        <a href="#" id="showTollsTable">Tolls</a>
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

            <table class="table" id="ticketsTable">
                <thread>
                    <h4 id="ticketsHeading">Tickets</h4>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>PCN</th>
                        <th>Date Issuer</th>
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
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{$ticket->name}}</td>
                            <td>{{$ticket->date}}</td>
                            <td>{{$ticket->pcn}}</td>
                            <td>{{$ticket->date}}</td>
                            <td>{{ $ticket->price }}</td>
                            @can('toll-pay')
                                @if ($ticket->status == '1')
                                    <td>Paid</td>
                                    <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a></td>
                                @elseif ($ticket->status == '0')
                                    <td>UnPaid</td>
                                    <td><a class="btn btn-danger" href="{{ route('ticket.pay', $ticket->id) }}">Pay</a></td>
                                @else
                                    <td>Disputed</td>
                                    <td><a class="btn btn-primary" href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                    </td>
                                @endif
                            @endcan
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="cityTable">
                <thread>
                    <h4 id="cityHeading">City Charges</h4>
                    <tr>
                        <th>No</th>
                        <th>City Name</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        @can('charges-pay')
                            <th>Pay</th>
                        @endcan
                    </tr>
                </thread>
                <tbody>
                    @foreach ($cities as $key => $city)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{$city->city}}</td>
                            <td>{{$city->time}}</td>
                            <td>{{ $city->price }}</td>
                            @can('city-pay')
                                @if ($city->status == '1')
                                    <td>Paid</td>
                                    <td><a class="btn btn-success" href="{{ route('charges.pay', $city->id) }}">Paid</a></td>
                                @elseif ($city->status == '0')
                                    <td>UnPaid</td>
                                    <td><a class="btn btn-danger" href="{{ route('charges.pay', $city->id) }}">Pay</a></td>
                                @else
                                    <td>Disputed</td>
                                    <td><a class="btn btn-primary" href="{{ route('charges.pay', $city->id) }}">Disputed</a>
                                    </td>
                                @endif
                            @endcan
                    @endforeach
                </tbody>
            </table>

            <table class="table" id="tollsTable">
                <thread>
                    <h4 id="tollsHeading">Tolls</h4> {{-- Initially hidden --}}
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Days</th>
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
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{$toll->name}}</td>
                            <td>{{$toll->date}}</td>
                            <td>{{$toll->pcn}}</td>
                            <td>{{$toll->date}}</td>
                            <td>{{ $toll->price }}</td>
                            @can('toll-pay')
                                @if ($toll->status == '1')
                                    <td>Paid</td>
                                    <td><a class="btn btn-success" href="{{ route('toll.pay', $toll->id) }}">Paid</a></td>
                                @elseif ($toll->status == '0')
                                    <td>UnPaid</td>
                                    <td><a class="btn btn-danger" href="{{ route('toll.pay', $toll->id) }}">Pay</a></td>
                                @else
                                    <td>Disputed</td>
                                    <td><a class="btn btn-primary" href="{{ route('toll.pay', $ticket->id) }}">Disputed</a>
                                    </td>
                                @endif
                            @endcan
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>


    <script>
        $(document).ready(function () {
            $("#showTollsTable").click(function () {
                $("#tollsTable").show();
                $("#tollsHeading").show();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").hide();
                $("#cityHeading").hide(); 
            });
    
            $("#showTicketsTable").click(function () {
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").show();
                $("#ticketsTable").show();
                $("#cityTable").hide();
                $("#cityHeading").hide(); 
            });
    
            $("#showCityTable").click(function () {
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").show();
                $("#cityHeading").show(); 
            });
        });
    </script>
@endsection

