<?php
$page = 'ticket';
?>

@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            font-size: 13px;
        }

        .pay {
            display: flex;
            justify-content: space-between;
        }

        .main {
            background: #8C52FF !important;
            color: #FFF;
        }

        .payMultiple {
            border-radius: 10px;
            background: #8C52FF;
            padding: 10px 8px;
            color: var(--white, #FFF);
            height: fit-content;
            font-weight: 500;
            width: 140px;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }
    </style>
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <div class="sort dropdown">
                    <p id="dropdown-toggle">Filter By<span class="caret"></span></p>
                    <div class="dropdown-content" id="dropdown-content">
                        <a href="#" id="paid">Paid</a>
                        <a href="#" id="unpaid">Unpaid</a>
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
            {{-- <div class="scroll">
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
                                <td>£ {{ number_format($ticket->price, 2) }}</td>
                                @can('toll-pay')
                                    @if ($ticket->status == '1')
                                        <td><a class="btn btn-success" href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                        </td>
                                    @elseif ($ticket->status == '0')
                                        <td><a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay Now</a>
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
                                <td></td>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->selectedDays) }}</td>
                                <td></td>
                                <td>Tolls</td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                @can('toll-pay')
                                    @if ($toll->status == 1)
                                        <td><a class="btn btn-success"
                                                href="{{ route('toll.pay', ['id' => $toll->paytoll_id, 'd_id' => $toll->pd]) }}">Paid</a>
                                        </td>
                                    @elseif ($toll->status == 0)
                                        <td><a class="btn main"
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
                                <td></td>
                                <td>{{ $city->city }}</td>
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
                                        <td><a class="btn main"
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
            </div> --}}

            <div class="scroll">
                <table class="table" id="ticket">
                    @if ($tickets->isEmpty())
                        <center>
                            <h3 id="ticket_0">Sorry, No tickets found</h3>
                        </center>
                    @else
                        <thread>
                            <h4 id="ticketsHeading" style="display:none; ">Tickets</h4>
                            <tr style="background-color: #F8F8FA">
                                <th><input type="checkbox" id="select-all" /> Select All</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>PCN</th>
                                <th>Ticket Issuer</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Notes</th>
                                <th>Status</th>
                                @can('ticket-pay')
                                    <th>Pay</th>
                                @endcan
                                {{-- <th>Delete</th> --}}
                            </tr>
                        </thread>
                        <tbody>
                            @foreach ($tickets as $key => $ticket)
                                <tr>
                                    <td><input type="checkbox" class="table-checkbox" data-table="tickets"
                                            data-price="{{ $ticket->price }}" name="ticket_ids[]"
                                            value="{{ $ticket->id }}"></td>
                                    {{-- <td><input type="checkbox" name="" id="" value="{{ $ticket->id }}"></td> --}}
                                    <!-- ... Rest of the table row ... -->
                                    <td>{{ $ticket->driver->name }}</td>
                                    <td>{{ $ticket->date }}</td>
                                    <td>{{ $ticket->pcn }}</td>
                                    <td>{{ $ticket->ticket_issuer }}</td>
                                    <td>Ticket</td>
                                    <td>£ {{ number_format($ticket->price, 2) }}</td>
                                    <td>{{ $ticket->notes }}</td>
                                    @can('toll-pay')
                                        @if ($ticket->status == '1')
                                            <td>Paid</td>
                                            <td><a class="btn btn-success"
                                                    href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                            </td>
                                        @elseif ($ticket->status == '0')
                                            <td>Unpaid</td>
                                            <td>
                                                <a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay
                                                    Now</a>
                                            </td>
                                        @elseif ($ticket->status == '2')
                                            <td>Disputed</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('ticket.pay', $ticket->id) }}">Disputed</a>
                                            </td>
                                        @endif
                                        {{-- <td>
                                            <form action="{{ route('ticket.delete', $ticket->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">Delete</button>
                                            </form>
                                        </td> --}}
                                    @endcan
                            @endforeach
                        </tbody>
                    @endif
                </table>
                <div id="ticket_page" class="pay">

                    {!! $tickets->withQueryString()->links('pagination::bootstrap-5') !!}
                    <a href="#" class="payMultiple" id="selectAllCheckboxItems">Pay multiple Tickets</a>

                </div>
                <div id="totalPriceDisplay" style="margin-top: 10px; font-size:14px;">
                    Total Price: £ 0.00
                </div>
            </div>

            <div class="scroll">
                <table class="table" id="unpaidTicket" style="display: none;">
                    @if ($unpaid->isEmpty())
                        <center>
                            <h3 id="unpaid_0" style="display: none;"> Sorry, No unpaid tickets found</h3>
                        </center>
                    @else
                        <thread>
                            <h4 id="unpaidHeading" style="display:none; ">Unpaid Tickets</h4>
                            <tr style="background-color: #F8F8FA">
                                <th>Name</th>
                                <th>Date</th>
                                <th>PCN</th>
                                <th>Ticket Issuer</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Notes</th>
                                <th>Status</th>
                                @can('ticket-pay')
                                    <th>Pay</th>
                                @endcan
                            </tr>
                        </thread>
                        <tbody>
                            @foreach ($unpaid as $key => $ticket)
                                <tr>
                                    <!-- ... Rest of the table row ... -->
                                    <td>{{ $ticket->driver->name }}</td>
                                    <td>{{ $ticket->date }}</td>
                                    <td>{{ $ticket->pcn }}</td>
                                    <td>{{ $ticket->ticket_issuer }}</td>
                                    <td>Ticket</td>
                                    <td>£ {{ number_format($ticket->price, 2) }}</td>
                                    <td>{{ $ticket->notes }}</td>
                                    @can('toll-pay')
                                        @if ($ticket->status == '1')
                                            <td>Paid</td>
                                            <td><a class="btn btn-success"
                                                    href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                            </td>
                                        @elseif ($ticket->status == '0')
                                            <td>Unpaid</td>
                                            <td>
                                                <a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay
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
                            @endforeach
                        </tbody>
                    @endif
                </table>
                <div id="unpaidTicket_page" style="display: none;">

                    {!! $unpaid->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div>

            <div class="scroll">
                <table class="table" id="paidTicket" style="display: none;">
                    @if ($paid->isEmpty())
                        <center>
                            <h3 id="paid_0" style="display: none;"> Sorry, No paid tickets found</h3>
                        </center>
                    @else
                        <thread>
                            <h4 id="paidHeading" style="display:none; ">Paid Tickets</h4>
                            <tr style="background-color: #F8F8FA">
                                <th>Name</th>
                                <th>Date</th>
                                <th>PCN</th>
                                <th>Ticket Issuer</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Notes</th>
                                <th>Status</th>
                                @can('ticket-pay')
                                    <th>Pay</th>
                                @endcan
                            </tr>
                        </thread>
                        <tbody>
                            @foreach ($paid as $key => $ticket)
                                <tr>
                                    <!-- ... Rest of the table row ... -->
                                    <td>{{ $ticket->driver->name }}</td>
                                    <td>{{ $ticket->date }}</td>
                                    <td>{{ $ticket->pcn }}</td>
                                    <td>{{ $ticket->ticket_issuer }}</td>
                                    <td>Ticket</td>
                                    <td>£ {{ number_format($ticket->price, 2) }}</td>
                                    <td>{{ $ticket->notes }}</td>
                                    @can('toll-pay')
                                        @if ($ticket->status == '1')
                                            <td>Paid</td>
                                            <td><a class="btn btn-success"
                                                    href="{{ route('ticket.pay', $ticket->id) }}">Paid</a>
                                            </td>
                                        @elseif ($ticket->status == '0')
                                            <td>Unpaid</td>
                                            <td>
                                                <a class="btn main" href="{{ route('ticket.pay', $ticket->id) }}">Pay
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
                            @endforeach
                        </tbody>
                    @endif
                </table>
                <div id="paidTicket_page" style="display: none">

                    {!! $paid->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </section>


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
        $("#unpaid").click(function() {
            $("#unpaidTicket").show();
            $("#unpaidHeading").show();
            $("#unpaid_0").show();
            $("#unpaidTicket_page").show();
            $("#ticket_0").hide();
            $("#paidTicket").hide();
            $("#paid_0").hide();
            $("#paidHeading").hide();
            $("#ticketsHeading").hide();
            $("#ticket").hide();
            $("#ticket_page").hide();
            $("#paidTicket_page").hide();
            $("#totalPriceDisplay").hide();
        });

        $("#paid").click(function() {
            $("#paidTicket").show();
            $("#paid_0").show();
            $("#paidHeading").show();
            $("paidTicket_page").show();
            $("#ticket_0").hide();
            $("#unpaid_0").hide();
            $("#unpaidTicket").hide();
            $("#unpaidHeading").hide();
            $("#ticketsHeading").hide();
            $("#ticket").hide();
            $("#ticket_page").hide();
            $("#unpaidTicket_page").hide();
            $("#totalPriceDisplay").hide();
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
                $('#totalPriceDisplay').text('Total Price: £ ' + totalPrice.toFixed(2));
            });

            // // Handle the "Pay multiple" button click
            // $('#selectAllCheckboxItems').click(function(event) {
            //     event.preventDefault();

            //     // At this point, the variable 'totalPrice' contains the cumulative price
            //     // for the selected checkboxes. You can use it to perform further actions.

            //     // For example, you can redirect to the payment page with the selected IDs and total price:
            //     window.location.href = "{{ route('bulk') }}?ids=" + selectedIds.join(',') + "&totalPrice=" + totalPrice;
            // });
        });
    </script>

@endsection
