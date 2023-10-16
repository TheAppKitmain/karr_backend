<?php
$page = 'ticket';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@extends('layouts.app')
@section('content')
    <style>
        .sort {
            width: 180px;
            height: 35px;
            background-color: #F8F8FA;
            border: 1px solid #F8F8FA;
            border-radius: 10px;

        }

        .sort p {
            margin-left: 10px;
            font-size: 12px;
            font-family: 'lato';
            font-weight: 500;
        }

        .sort span {
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
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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

        .scroll {
            display: block;
            overflow-x: auto;
        }
        .table td{
            font-size: 13px;
        }
    </style>
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <a href="#" id="selectAllCheckboxItems">Pay multiple Tickets</a>
                <div class="sort dropdown">
                    <p>Filter By<span class="caret"></span></p>
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
            <div class="scroll">
                <table class="table" id="AllTable">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th>Check</th>
                            <th>PCN</th>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Issued by</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tickets" name="ticket_ids[]"
                                        value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£ {{ $ticket->price }}</td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-danger" href="{{ route('ticket.pay', $ticket->id) }}">Pay Now</a>
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
                                        value="{{ $toll->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                <td></td>
                                <td>Tolls</td>
                                <td>£ {{ $toll->price }}</td>
                                @can('toll-pay')
                                    @if ($toll->tollDrivers->first()->status == 1)
                                        <td><a class="btn btn-success" href="{{ route('toll.pay',['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id] ) }}">Paid</a></td>
                                    @elseif ($toll->tollDrivers->first()->status == 0)
                                        <td><a class="btn btn-danger" href="{{ route('toll.pay',['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id ]) }}">Pay Now</a>
                                        </td>
                                    @elseif($toll->tollDrivers->first()->status == 2)
                                        <td><a class="btn btn-primary" href="{{ route('toll.pay',['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id ]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($cities as $city)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="city" name="city_ids[]"
                                        value="{{ $city->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->time }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£ {{ $city->price }}</td>
                                @can('toll-pay')
                                    @if ($city->cityDrivers->first()->status == 1)
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->cityDrivers->first()->status == 0)
                                        <td><a class="btn btn-danger"
                                                href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Pay
                                                Now</a></td>
                                    @elseif ($city->cityDrivers->first()->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Disputed</a>
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
                            <th>Status</th>
                            @can('ticket-pay')
                                <th>Pay</th>
                            @endcan
                        </tr>
                    </thread>
                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" name="" id="" value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£ {{ $ticket->price }}</td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td>Paid</td>
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td>Unpaid</td>
                                        <td>
                                            <a class="btn btn-danger" href="{{ route('ticket.pay', $ticket->id) }}">Pay Now</a>
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
                                        value="{{ $city->id }}"></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->time }}</td>
                                <td>£ {{ $city->price }}</td>
                                <td>Charges</td>
                                @can('toll-pay')
                                    @if ($city->cityDrivers->first()->status == 1)
                                    <td>Paid</td>
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->cityDrivers->first()->status == 0)
                                    <td>Unpaid</td>
                                        <td><a class="btn btn-danger"
                                                href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Pay
                                                Now</a></td>
                                    @elseif ($city->cityDrivers->first()->status == 2)
                                    <td>Disputed</td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('charges.pay', ['id' => $city->cityDrivers->first()->city_id, 'd_id' => $city->cityDrivers->first()->driver_id]) }}">Disputed</a>
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
                                <td>£ {{ $toll->price }}</td>
                                @can('toll-pay')
                                    @if ($toll->tollDrivers->first()->status == 1)
                                        <td> Paid </td>
                                        <td><a class="btn btn-success" href="{{ route('toll.pay',['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id ]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->tollDrivers->first()->status == 0)
                                        <td> Unpaid</td>
                                        <td><a class="btn btn-danger" href="{{ route('toll.pay',['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id ]) }}">Pay Now</a>
                                        </td>
                                    @elseif($toll->tollDrivers->first()->status == 2)
                                        <td> Disputed </td>
                                        <td><a class="btn btn-primary" href="{{ route('toll.pay',['id' => $toll->tollDrivers->first()->paytoll_id, 'd_id' => $toll->tollDrivers->first()->driver_id ]) }}">Disputed</a>
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
            $("#showTollsTable").click(function() {
                $("#tollsTable").show();
                $("#tollsHeading").show();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#AllTable").hide();
            });

            $("#showTicketsTable").click(function() {
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").show();
                $("#ticketsTable").show();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#AllTable").hide();
            });

            $("#showCityTable").click(function() {
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").show();
                $("#cityHeading").show();
                $("#AllTable").hide();
            });
        });
    </script>
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
        });
    </script>
@endsection
