<?php
$page = 'city';
?>
@extends('layouts.app')
@section('content')
    <section class="profile-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content">
                        <h3>Edit City Charges</h3>
                    </div>
                    <form action="{{ route('charges.update', $charge->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Area</label>
                                <input type="text" class="form-control" placeholder="Area" name="area"
                                    value="{{ $charge->area }}">
                            </div> 
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" placeholder="City" name="city"
                                    value="{{ $charge->city }}">
                            </div>
                            <div class="form-group">
                                <label>Charges</label>
                                <input type="text" class="form-control" placeholder="Charges" name="price"
                                    value="{{ $charge->price }}">
                            </div>
                            <div class="form-group">
                                <label>Time</label>
                                <input type="text" class="form-control" placeholder="Time" name="time"
                                    value="{{ $charge->time }}">
                            </div>

                        </div>



                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                    <a href="{{route('city')}}">Back</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Save changes</button>
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
                        <p>Edit City Charges.</p>
                    </div>
                    <div class="quick-review-img">
                        <img src="{{ asset('assets/dist/img/thanks.jpg') }}">
                    </div>
                </div>
            </div>


        </div>

    </section>
@endsection
