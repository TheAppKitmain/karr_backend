<?php
$page = 'driver';
?>
@extends('layouts.app')
@section('content')
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <h3>Tickets</h3>
            </div>

            <table class="table">
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
                <thread>
                    <tr>
                        <th>No</th>
                        <th>Driver</th>
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
                            <th>{{$ticket->driver->name}}</th>
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
        </div>
    </section>
@endsection
