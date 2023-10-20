<?php
$page = 'tolls';
?>
@extends('layouts.app')
@section('content')
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

        .scroll {
            display: block;
            overflow-x: auto;
        }
    </style>
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left" style="width: 50rem;">
                    <div class="welcome-inner-content" style="display:flex;">

                        <button href="#" id="ticket" class="home">
                            Parking Tickets
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
            <div class="scroll">
                <table class="table" id="AllTable">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
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
                        @foreach ($tolls as $toll)
                            <?php $name = 'tl'; ?>
                            <tr>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                <td> Tolls </td>
                                @can('admin-ticket')
                                    <td>{{ $toll->user_name }}</td>
                                @endcan
                                <td></td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>

                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn btn-danger"
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.unpaid', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Mark
                                                unpaid</a>
                                        </td>
                                    @elseif ($toll->status == '0')
                                        <td><a class="btn btn-danger"
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
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->date }}</td>
                                <td> City Charge </td>
                                @can('admin-ticket')
                                    <td>{{ $city->user_name }}</td>
                                @endcan
                                <td></td>
                                <td>£ {{ number_format($city->price, 2) }}</td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-danger"
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
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.unpaid', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Mark
                                                unpaid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a
                                                class="btn btn-danger"href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Pay
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
                </table>
            </div>
            <div class="scroll" style="display: none">
                <table class="table" id="tollsTable">
                    <thread>
                        <h4 id="tollsHeading">Tolls</h4> {{-- Initially hidden --}}
                        <tr style="background-color:#F8F8FA;">
                            <th>Check</th>
                            <th>Name</th>
                            <th>Days</th>
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
                                <td>{{ $toll->name }}</td>
                                <td>
                                    {{ implode(', ', $toll->selectedDays) }}
                                </td>
                                <td>Tolls</td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td> Paid </td>
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td> Unpaid</td>
                                        <td><a class="btn btn-danger"
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
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $("#ticket").click(function() {
                // Add the CSS class to the clicked button
                $(this).addClass('homeChange');

                // Remove the CSS class from the other button
                $("toll").removeClass('homeChange');
                $("charges").removeClass('homeChange');

                // Show/hide elements as needed
                // $("#pay").show();
                // $("#add").hide();
            });

            $("#toll").click(function() {
                // Add the CSS class to the clicked button
                $(this).addClass('homeChange');

                // Remove the CSS class from the other button
                $("ticket").addClass('homeChange');
                $("charge").addClass('homeChange');

                // Show/hide elements as needed
            });
            $("#charge").click(function() {
                // Add the CSS class to the clicked button
                $(this).addClass('homeChange');

                // Remove the CSS class from the other button
                $("ticket").removeClass('homeChange');
                $("charge").removeClass('homeChange');

            });
        });
    </script>
@endsection
