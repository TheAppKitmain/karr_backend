<?php
$page = 'toll';
?>
@extends('layouts.app')
@section('content')
    <section class="profile-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content">
                        <h3>edit toll</h3>
                    </div>
                    <form action="{{ route('toll.update', $tolls->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name"
                                    value="{{ $tolls->name }}">
                            </div>
                            <div class="form-group">
                                <label>Charges</label>
                                <input type="text" class="form-control" placeholder="Price" name="price"
                                    value="{{ $tolls->price }}">
                            </div>
                            <div class="form-group">
                                <label>Days Selected</label>
                                <input type="text" class="form-control" value=" {{ implode(', ', $tolls->selectedDays) }}"
                                    readonly>
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
                                    <a href="{{route('toll')}}">Back</a>
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

        </div>

    </section>
@endsection
