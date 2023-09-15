<?php
$page = 'driver';
?>
@extends('layouts.app')
@section('content')
    <section class="profile-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content">
                        <h3>edit profile</h3>
                    </div>
                    <form action="{{ route('drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
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
                                    value="{{ $driver->name }}">
                            </div>
                            <div class="form-group">
                                <label>License</label>
                                <input type="text" class="form-control" placeholder="License" name="license"
                                    value="{{ $driver->license }}">
                            </div>
                            <div class="form-group">
                                <label>Number</label>
                                <input type="text" class="form-control" placeholder="Number" name="number"
                                    value="{{ $driver->license }}">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image" value="{{ $driver->image }}">
                            </div>

                        </div>

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                    <a href="{{route('drivers.index')}}">cancel</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Save changes</button>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="welcome-screen-right">
                    <div class="quick-review-contant">
                        <h3>Change password</h3>
                        <p>Update your password with new strong password?</p>
                    </div>
                    <div class="welcome-screen-form">
                        <div class="form-group">
                            <label>password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>confirm password</label>
                            <input type="password" name="confirm-password" placeholder="Confirm Password"
                                class="form-control">
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>

    </section>
@endsection
