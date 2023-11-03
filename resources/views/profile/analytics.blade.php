<?php
$page = 'analytics';
?>
@extends('layouts.app')
@section('content')
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                           <h3 style="margin-bottom:10px"> Ticket Total Amount </h3>
                        </div>
                        <div class="card-body"><canvas id="myTicketChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                           <h3 style="margin-bottom:10px"> Charges Total Amount </h3>
                        </div>
                        <div class="card-body"><canvas id="myCityChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            <h3 style="margin-bottom:10px">Tolls Total Amount</h3>
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            <h3 style="margin-bottom:10px">Summary</h3>
                        </div>
                        <div class="card-body"><canvas id="summaryChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var _ydata = JSON.parse('{!! json_encode($tollMonths) !!}');
        var _xdata = JSON.parse('{!! json_encode($tollPrice) !!}');

        var _ycharge = JSON.parse('{!! json_encode($chargeMonths) !!}');
        var _xcharge = JSON.parse('{!! json_encode($chargePrice) !!}');

        var _yticket = JSON.parse('{!! json_encode($ticketMonths) !!}');
        var _xticket = JSON.parse('{!! json_encode($ticketPrice) !!}');

        var _xsummary = JSON.parse('{!! json_encode($summaryPrice) !!}');
    </script>
    <script src="{{ asset('assets/bootstrap/js/charges.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/barChart.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/ticketChart.js')}}"></script>
    <script src="{{ asset('assets/bootstrap/js/totalChart.js')}}"></script>

@endsection
