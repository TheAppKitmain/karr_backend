<?php
$page = 'setting';
?>
@extends('layouts.app')
@section('content')
    <style>
        .add-btns {
            text-align: right;
        }

        .btn-main {
            background: #8C52FF;
            color: #fff;

        }
    </style>
    <section class="profile-screen">
        <div class="row">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="welcome-screen-left">
                        <div class="welcome-inner-content">
                            <h3>Edit Profile</h3>
                            <p>You can edit your profile and save once complete</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @csrf
                        @method('PUT')
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Business Name</label>
                                <input type="text" class="form-control" placeholder="Business" name="business"
                                    value="{{ $user->business }}">
                            </div>
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

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" placeholder="Image" name="image">
                            </div>

                        </div>

                        <input type="hidden" name="roles" value="Admin">

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btns">
                                    <button type="button" class="btn primary">Cancel</button>
                                    <button type="submit" class="btn btn-main">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="welcome-screen-right">
                        <div class="quick-review-contant">
                            <h3>Change Password</h3>
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
                                <label>Confirm Password</label>
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
