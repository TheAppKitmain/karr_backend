<?php
$page = 'tickets';
?>
@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

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

        .dropdown-content {
            display: none;
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

        .table td {
            font-size: 12px;
        }

        .pay {
            display: flex;
            margin-bottom: 10px;
        }

        .main {
            background: #8C52FF !important;
            color: #FFF;
        }

        .for-our-services {
            margin-bottom: 10px;
        }

        .btn-dark {
            color: #fff;
            background-color: #000;

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
            /* Hide notes by default */
        }
    </style>
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <h4 style="margin-bottom: 10px"><strong>Tickets & Charges</strong></h4>
                {{-- <a href="#" id="selectAllCheckboxItems">Pay multiple Tickets</a> --}}
                <div class="sort dropdown">
                    <p id="dropdown-toggle">Filter By<span class="caret"></span></p>
                    <div class="dropdown-content" id="dropdown-content">
                        <a href="#" id="showPaidTable">Paid</a>
                        <a href="#" id="showUnpaidTable">Unpaid</a>
                    </div>
                </div>
            </div>

            <div class="pay">
                <a href="#" class="payMultiple" id="selectAllCheckboxItems">Pay Multiple Tickets</a>
            </div>
            <div id="totalPriceDisplay" style="font-size 14px; margin-left:10px ">
                Total Price: £0.00
            </div>
            {{-- <div class="pay">
            </div> --}}
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
                <table class="table" id="Alltable">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th><input type="checkbox" id="select-all" /> Select All</th>
                            <th>Name</th>
                            <th>PCN</th>
                            <th>Date</th>
                            <th>Business</th>
                            <th>Issued</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <?php $name = 'tk'; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="table-checkbox" data-table="tickets"
                                        data-price="{{ $ticket->price }}" data-toll-id="{{ $ticket->id }}"
                                        data-driver-id="{{ $ticket->driver_id }}" name="selected_items[]"
                                        value="{{ $ticket->id }}">
                                </td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->user_name }} </td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ number_format($ticket->price, 2) }}</td>
                                @if ($ticket->image)
                                    <td>
                                        <a href="{{ asset('ticket/' . $ticket->image) }}" data-fancybox="gallery">
                                            <img src="{{ asset('assets/dist/img/eye.png') }}">
                                        </a>

                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>

                                        </div>
                                    @endif
                                </td>



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
                                        data-price="{{ $toll->price }}" data-toll-id="{{ $toll->paytoll_id }}"
                                        data-driver-id="{{ $toll->pd }}" name="selected_items[]"
                                        value="{{ $toll->paytoll_id }}">
                                </td>
                                <td>{{ $toll->name }}</td>
                                <td></td>
                                <td>{{ $toll->date }}</td>
                                <td>{{ $toll->user_name }}</td>
                                <td></td>
                                <td>Toll</td>
                                <td>£{{ number_format($toll->price, 2) }}</td>
                                <td></td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif

                                </td>
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
                                    @elseif($toll->status == '2')
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
                                <td>
                                    <input type="checkbox" class="table-checkbox" data-table="city"
                                        data-price="{{ $city->price }}" data-toll-id="{{ $city->city_id }}"
                                        data-driver-id="{{ $city->cd }}" name="selected_items[]"
                                        value="{{ $city->city_id }}">
                                </td>
                                <td>{{ $city->city }}</td>
                                <td></td>
                                <td>{{ $city->date }}</td>
                                <td>{{ $city->user_name }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£{{ number_format($city->price, 2) }}</td>
                                <td></td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
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
                                    @elseif ($city->status == 2)
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cityDrivers->first()->driver_id, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
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
                            <th>Issued</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unpaidTickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="" data-table="" name=""
                                        value="{{ $ticket->id }}"></td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£{{ number_format($ticket->price, 2) }}</td>
                                @if ($ticket->image)
                                    <td>
                                        <a href="{{ asset('ticket/' . $ticket->image) }}" data-fancybox="gallery">
                                            <img src="{{ asset('assets/dist/img/eye.png') }}">
                                        </a>
                                    @else
                                    <td></td>
                                @endif
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('admin-ticket')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-dark"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Mark
                                                unpaid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-success"
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
                                    <input type="checkbox" class="" data-table="" name="" value="">

                                </td>
                                <td></td>
                                <td>{{ $toll->name }}</td>
                                <td>{{ $toll->date }}</td>
                                <td></td>
                                <td>Toll</td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                <td></td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('admin-ticket')
                                    @if ($toll->status == '1')
                                        <td><a class="btn btn-dark"
                                                href="{{ route('admin.unpaid', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Mark
                                                unpaid</a>
                                        </td>
                                    @elseif ($toll->status == '0')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif($toll->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Disputed</a>
                                        </td>
                                    @endif
                                @endcan
                            </tr>
                        @endforeach

                        @foreach ($unpaidCharges as $city)
                            <tr>
                                <td><input type="checkbox" class="" data-table="" name="" value="">
                                </td>
                                <!-- ... Rest of the table row ... -->

                                <td></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->time }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£ {{ number_format($city->price, 2) }}</td>
                                <td></td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('admin-ticket')
                                    @if ($city->status == '1')
                                        <td>
                                            <a class="btn btn-dark"
                                                href="{{ route('admin.unpaid', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Mark
                                                unpaid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($city->status == 2)
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
            <div class="scroll">
                <table class="table" id="paidTable" style="display: none" <?php $count = 1; ?>>
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th>Check</th>
                            <th>PCN</th>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Issued</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Notes</th>
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
                                <td>£{{ number_format($ticket->price, 2) }}</td>
                                @if ($ticket->image)
                                    <td>
                                        <a href="{{ asset('ticket/' . $ticket->image) }}" data-fancybox="gallery">
                                            <img src="{{ asset('assets/dist/img/eye.png') }}">
                                        </a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td>
                                    @if ($ticket->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $ticket->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('admin-ticket')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-dark"
                                                href="{{ route('admin.pay', ['id' => $ticket->id, 'd_id' => $ticket->driver_id, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn btn-success"
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
                                <td>{{ $toll->date }}</td>
                                <td></td>
                                <td>Toll</td>
                                <td>£{{ number_format($toll->price, 2) }}</td>
                                <td></td>
                                <td>
                                    @if ($toll->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $toll->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('admin-ticket')
                                    @if ($toll->status == '1')
                                        <td><a class="btn btn-dark"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == '0')
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Pay
                                                Now</a></td>
                                    @elseif($toll->status == '2')
                                        <td><a class="btn btn-primary"
                                                href="{{ route('admin.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd, 'name' => $name]) }}">Disputed</a>
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
                                <td>£{{ number_format($city->price, 2) }}</td>
                                <td></td>
                                <td>
                                    @if ($city->notes)
                                        <div class="notes-container">
                                            <a href="#" class="toggle-notes">
                                                <img src="{{ asset('assets/dist/img/eye.png') }}" alt="notes">
                                            </a>
                                            <div class="notes">{{ $city->notes }}</div>
                                        </div>
                                    @endif
                                </td>
                                @can('admin-ticket')
                                    @if ($city->status == '1')
                                        <td><a class="btn btn-dark"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-success"
                                                href="{{ route('admin.pay', ['id' => $city->city_id, 'd_id' => $city->cd, 'name' => $name]) }}">Pay
                                                Now</a>
                                        </td>
                                    @elseif ($city->status == 2)
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
        </div>
    </section>

    {{-- On Click table hide --}}
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
    {{-- Checkboxes --}}
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
    </script>

    {{-- price of checked items --}}
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
                $('#totalPriceDisplay').text('Total Price: £' + totalPrice.toFixed(2));
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
            $(document).ready(function() {
                $('#AllTable').on('click', '.toggle-notes', function(e) {
                    e.preventDefault();
                    var notesContainer = $(this).closest('tr').find('.notes-container');
                    notesContainer.find('.notes').toggle();
                    notesContainer.find('img').toggle();
                });
            });
            $(document).ready(function() {
                $('#unpaidTable').on('click', '.toggle-notes', function(e) {
                    e.preventDefault();
                    var notesContainer = $(this).closest('tr').find('.notes-container');
                    notesContainer.find('.notes').toggle();
                    notesContainer.find('img').toggle();
                });
            });
            $(document).ready(function() {
                $('#paidTable').on('click', '.toggle-notes', function(e) {
                    e.preventDefault();
                    var notesContainer = $(this).closest('tr').find('.notes-container');
                    notesContainer.find('.notes').toggle();
                    notesContainer.find('img').toggle();
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#Alltable').DataTable();
        });
    </script>
@endsection
