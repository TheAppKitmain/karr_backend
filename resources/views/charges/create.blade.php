<?php
$page = 'city';
?>
@extends('layouts.app')
@section('content')
    <section class="guest-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="guest-screen-left">
                    <div class="guest-inner-content">
                        <h3>Create City Charges</h3>
                    </div>
                    <form action="{{ route('charges.store') }}" method="POST">
                        @csrf
                        <div class="guest-screen-form">
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Area</label>
                                <input type="text" name="area" id="" placeholder="Enter Area" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" id="" placeholder="Enter City" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Charges</label>
                                <input type="text" name="price" placeholder="Enter Charges" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Time</label>
                                <input type="text" name="time" class="form-control" placeholder="For how much time">
                            </div>
                        </div>

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                     <a href="{{route('city')}}" class="btn-secondary">Back</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Add Charges</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12" id="quick-sticky">
                <div class="guest-screen-right">
                    <div class="quick-review-contant">
                        <h3>Quick preview</h3>
                        <p>Create City Charges.</p>
                    </div>
                    <div class="quick-review-img">
                        <img src="{{ asset('assets/dist/img/thanks.jpg') }}">
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
