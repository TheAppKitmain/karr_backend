<?php
$page = 'tickets';
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
    </style>
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <a href="#" id="selectAllCheckboxItems">Pay multiple Tickets</a>
                <div class="sort dropdown">
                    <p>Filter By<span class="caret"></span></p>
                    <div class="dropdown-content">
                        <a href="#" id="showPaidTable">Paid</a>
                        <a href="#" id="showUnpaidTable">Unpaid</a>
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
                    <h4>Tickets & charges</h4>
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
                            <?php $name = 'tk'; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="table-checkbox" data-table="tickets"
                                    data-toll-id="{{ $ticket->id }}" data-driver-id="{{ $ticket->driver_id }}"
                                    name="selected_items[]" value="{{ $ticket->id}}">
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ $ticket->price }}</td>
                                @can('admin-ticket')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
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
                                <td>   
                                <input type="checkbox" class="table-checkbox" data-table="tolls"
                                    data-toll-id="{{ $toll->paytoll_id }}" data-driver-id="{{ $toll->driver_id }}"
                                    name="selected_items[]" value="{{ $toll->paytoll_id }}">
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                <td></td>
                                <td>Toll</td>
                                <td>£{{ $toll->price }}</td>
                                @can('admin-ticket')
                                    @if ($toll->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == '0')
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($cities as $city)
                            <?php $name = 'ct'; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="table-checkbox" data-table="city"
                                    data-toll-id="{{ $city->city_id }}" data-driver-id="{{ $city->driver_id }}"
                                    name="selected_items[]" value="{{ $city->city_id }}">
                                </td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->time }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£{{ $city->price }}</td>
                                @can('admin-ticket')
                                    @if ($city->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endcan
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="scroll">
                <table class="table" id="unpaidTable" style="display: none" <?php $count = 1; ?>>
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
                        @foreach ($unpaidTickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tickets" name="ticket_ids[]"
                                        value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ $ticket->price }}</td>
                                @can('admin-ticket')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($unpaidTolls as $toll)
                            <tr>
                                <td>
                                    <input type="checkbox" class="table-checkbox" data-table="tolls"
                                        data-toll-id="{{ $toll->paytoll_id }}" data-driver-id="{{ $toll->driver_id }}"
                                        name="selected_items[]" value="{{ $toll->paytoll_id }}">

                                </td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                <td></td>
                                <td>Toll</td>
                                <td>£{{ $toll->price }}</td>
                                @can('admin-ticket')
                                    @if ($toll->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == '0')
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($unpaidCharges as $city)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="city" name="city_ids[]"
                                        value="{{ $city->city_id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->time }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£{{ $city->price }}</td>
                                @can('admin-ticket')
                                    @if ($city->status == '1')
                                        <td>
                                            <a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="scroll">
                <table class="table" id="paidTable" style="display: none" <?php $count = 1; ?>>
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
                        @foreach ($paidTickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="" data-table="" name=""
                                        value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ $ticket->price }}</td>
                                @can('admin-ticket')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($ticket->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($paidTolls as $toll)
                            <tr>
                                <td><input type="checkbox" class="" data-table="" name=""
                                        value="{{ $toll->paytoll_id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                <td></td>
                                <td>Toll</td>
                                <td>£{{ $toll->price }}</td>
                                @can('admin-ticket')
                                    @if ($toll->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == '0')
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Pay
                                                Now</a></td>
                                    @elseif($toll->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($paidCharges as $city)
                            <tr>
                                <td><input type="checkbox" class="" data-table="" name=""
                                        value="{{ $city->city_id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->time }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£{{ $city->price }}</td>
                                @can('admin-ticket')
                                    @if ($city->status == '1')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            $("#showPaidTable").click(function() {
                $("#paidTable").show();
                $("#unpaidTable").hide();
                $("#AllTable").hide();
            });

            $("#showUnpaidTable").click(function() {
                $("#unpaidTable").show();
                $("#paidTable").hide();
                $("#AllTable").hide();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // When the "Pay multiple Tickets" anchor tag is clicked
            $('#selectAllCheckboxItems').click(function(event) {
                event.preventDefault(); // Prevent the default link behavior

                var selectedItems = [];

                // Iterate through all checkboxes with the "table-checkbox" class
                $('.table-checkbox:checked').each(function() {
                    var table = $(this).data('table');
                    var tollId = $(this).data('toll-id');
                    var driverId = $(this).data('driver-id');

                    // Add the IDs and table name to the selectedItems array
                    selectedItems.push({
                        table: table,
                        toll_id: tollId,
                        driver_id: driverId
                    });
                });

                if (selectedItems.length > 0) {
                    var encodedItems = encodeURIComponent(JSON.stringify(selectedItems));
                    var url = "{{ route('marked.pay') }}?items=" + encodedItems;
                    window.location.href = url;
                } else {
                    // Handle the case when no items are selected
                    alert('No items are selected.');
                }
            });
        });
    </script>
@endsection
