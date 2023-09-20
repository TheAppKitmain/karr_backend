<?php
$ticketCount = $tickets->count();
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
            left: 13px;
        }
        .homeText p{
            color: #ffffff;
        }
        .homeText span{
            font-family: lato;
            font-weight: 700;
            font-size: 26px;

        }
    </style>
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content" style="height:130px">

                        <div class="col-3 home" style="background: #8C52FF;">
                            <div class="homeText">
                                <p>Total Tickets</p>
                                <span>{{ $ticketCount }}</span>
                            </div>

                        </div>
                        <div class="col-3 home" style="background: #5A9FD6; ">
                            <div class="homeText">
                                <p>Unpaid Tickets</p>
                                <span>{{ $unpaidTicket }}</span>
                            </div>

                        </div>
                        <div class="col-3 home" style="background:  #FFB400;">
                            <div class="homeText">
                                <p>Total Charges</p>
                                <span>£{{ $totalCharges }}</span>
                            </div>

                        </div>
                        <div class="col-3 home" style="background:  #FF6F73;">
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
                <table class="table">
                    <thread>
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
                        <tr style="background: #F8F8FA">
                            <th>No</th>
                            <th>PCN</th>
                            <th>Ticket Issuer</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Pay Now</th>
                        </tr>
                    </thread>

                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>

                                <td>{{ $ticket->pcn }}</td>
                                <td>{{$ticket->ticket_issuer}}</td>
                                <td>{{$ticket->price}}</td>

                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td>Paid</td>
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td>Pending</td>
                                        <td><a class="btn btn-danger" href="{{ route('ticket.pay', $ticket->id) }}">Pay</a>
                                        </td>
                                    @else
                                        <td>Disputed</td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>


    </section>
@endsection
