<?php
$page = 'setting';
?>
@extends('layouts.app')
@section('content')
    <section class="profile-screen">
        <div class="row">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="welcome-screen-left">
                        <div class="welcome-inner-content">
                            <h3>Edit Profile</h3>
                            <p>You can edit your profile and save once complete</p>
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
                        @csrf
                        @method('PUT')
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email"
                                    value="{{ $user->email }}">
                            </div>
                        </div>

                        <input type="hidden" name="roles" value="Admin">

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">

                                    <a href="#">cancel</a>

                                    <button type="submit" class="btn btn-primary">Updated</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="welcome-screen-right">
                        <div class="quick-review-contant">
                            <h3>Change Password</h3>
                            <p>Update your password with new strong password?</p>
                        </div>
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" name="old" placeholder="Old Password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Password" class="form-control">
                            </div>


                            <div class="form-group">
                                <label>Confirm password</label>
                                <input type="password" name="confirm-password" placeholder="Confirm Password"
                                    class="form-control">
                            </div>
                            <div class="add-btn">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>

    </section>
@endsection
