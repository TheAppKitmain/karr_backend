<?php
$page = 'toll';
?>
@extends('layouts.app')
@section('content')
    <section class="guest-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="guest-screen-left">
                    <div class="guest-inner-content">
                        <h3>Create Toll</h3>
                    </div>
                    <form action="{{ route('toll.store') }}" method="POST">
                        @csrf

                        <div class="guest-screen-form">
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="" placeholder="Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Toll Fee</label>
                                <input type="float" name="price" placeholder="£ Toll Fee" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Days</label>
                                <select name="days[]" multiple class="form-control">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                    <a href="{{ route('toll') }}" class="btn-secondary">Back</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Add Toll</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            {{-- <div class="col-lg-4 col-md-4 col-sm-12" id="quick-sticky">
                <div class="guest-screen-right">
                    <div class="quick-review-contant">
                        <h3>Quick preview</h3>
                        <p>Create Toll.</p>
                    </div>
                    <div class="quick-review-img">
                        <img src="{{ asset('assets/dist/img/thanks.jpg') }}">
                    </div>
                </div>
            </div> --}}

        </div>
    </section>
@endsection
