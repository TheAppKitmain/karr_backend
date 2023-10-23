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
                <div class="welcome-screen-left">
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
            <div class="welcome-inner-content" style="display:flex;">
                <a style="background:#8C52FF; margin-bottom:10px;" href="#" id="selectAllCheckboxItems">Pay multiple Tickets</a>
            </div>
            <div class="scroll">
                <table class="table" id="AllTable">
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $key => $ticket)
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" data-table="tickets" name="ticket_ids[]"
                                        value="{{ $ticket->id }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $ticket->driver->name }}</td>
                                <td>{{ $ticket->pcn }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->ticket_issuer }}</td>
                                <td>Ticket</td>
                                <td>£ {{ number_format($ticket->price, 2) }}</td>
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
                                        value="{{ $toll->pd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $toll->name }}</td>
                                <td></td>
                                <td>{{  $toll->date }}</td>
                                <td></td>
                                <td>Tolls</td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn btn-danger"
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
                                        value="{{ $city->cd }}"></td>
                                <!-- ... Rest of the table row ... -->
                                <td>{{ $city->city }}</td>
                                <td></td>
                                <td>{{ $city->date }}</td>
                                <td></td>
                                <td>Charges</td>
                                <td>£ {{ number_format($city->price, 2) }}</td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td><a class="btn btn-danger"
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
                                <td>£ {{ number_format($ticket->price, 2) }}</td>
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
                                        value="{{ $city->cd }}"></td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->date }}</td>
                                <td>£ {{ number_format($city->price, 2) }}</td>
                                <td>Charges</td>
                                @can('toll-pay')
                                    @if ($city->status == 1)
                                        <td>Paid</td>
                                        <td><a class="btn btn-success"
                                                href="{{ route('charges.pay', ['id' => $city->city_id, 'd_id' => $city->cd]) }}">Paid</a>
                                        </td>
                                    @elseif ($city->status == 0)
                                        <td>Unpaid</td>
                                        <td><a class="btn btn-danger"
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
            $("#toll").click(function() {
                $(this).addClass('homeChange');
                $("#ticket").removeClass('homeChange');
                $("#charge").removeClass('homeChange');
                $("#tollsTable").show();
                $("#tollsHeading").show();
                $("#ticketsHeading").hide();
                $("#ticketsTable").hide();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#AllTable").hide();
            });

            $("#ticket").click(function() {
                $(this).addClass('homeChange');
                $("#toll").removeClass('homeChange');
                $("#charge").removeClass('homeChange');
                $("#tollsTable").hide();
                $("#tollsHeading").hide();
                $("#ticketsHeading").show();
                $("#ticketsTable").show();
                $("#cityTable").hide();
                $("#cityHeading").hide();
                $("#AllTable").hide();
            });

            $("#charge").click(function() {
                $(this).addClass('homeChange');
                $("#toll").removeClass('homeChange');
                $("#ticket").removeClass('homeChange');
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
        // var dropdownToggle = document.getElementById("dropdown-toggle");
        // var dropdownContent = document.getElementById("dropdown-content");

        // // Add a click event listener to the toggle button
        // dropdownToggle.addEventListener("click", function() {
        //     if (dropdownContent.style.display === "block") {
        //         dropdownContent.style.display = "none";
        //     } else {
        //         dropdownContent.style.display = "block";
        //     }
        // });

        // // Close the dropdown if the user clicks outside of it
        // window.addEventListener("click", function(event) {
        //     if (event.target !== dropdownToggle && event.target !== dropdownContent) {
        //         dropdownContent.style.display = "none";
        //     }
        // });
    </script>
        <script>
            $(document).ready(function() {
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
@endsection
