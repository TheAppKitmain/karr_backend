<?php
$page = 'driver';
?>
@extends('layouts.app')
@section('content')
    <section class="create-services-screen">
        <div class="row create-services-screen-left">
            <div class="col-lg-12">
                <div class="for-our-services">
                    <h3>Assign Car to Driver</h3>
                </div>
            </div>



            <div class="col-lg-12 border-both">
                @if ($cars->count() == 0)
                    <h4 style="text-align: center">No cars yet to assign</h4>
                @endif
                @foreach ($cars as $car)
                <div class="col-lg-3 col-md-6 col-sm-12 pl-0">
                    <div class="services-slider">
                            <img src="{{ asset('image/' . $car->image) }}" width="150" height="150">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="services-content">
                        <h4>{{ $car->make }}</h4>
                        <p>{{ $car->number }}<br></p>
                        <h4>{{ $car->dor }} </h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 pr-0">
                    <div class="edit-delete-btn">
                        <a href="{{ route('assign.car', [$car->id, $driver->id]) }}" class="edit">Assign</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </section>
@endsection
