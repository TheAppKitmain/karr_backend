<?php
$page = 'user';
?>
@extends('layouts.app')
@section('content')
    {{-- <section class="profile-screen">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit New User</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-outline-primary" href="{{ route('users.index') }}" style='margin-bottom: 10px;'>
                        Back</a>
                </div>
            </div>
        </div>
        <form action="{{ route('users.update', $user->id) }}" method="PUT">
            @csrf
            <div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Name" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" placeholder="Email" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
                </div>
            </div>
            @can('role-list')
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Role:</strong>
                        <select name="roles[]" class="form-control" multiple>
                            @foreach ($roles as $roleKey => $roleValue)
                                <option value="{{ $roleKey }}" {{ in_array($roleKey, $userRole) ? 'selected' : '' }}>
                                    {{ $roleValue }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
            @endcan
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-outline-success">Submit</button>
            </div>
        </form>
    </section> --}}
    <section class="profile-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content">
                        <h3>Edit profile</h3>
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <label>Roles</label>
                                <input type="text" name="roles" value="Admin" readonly class="form-control"> 
                            </div>
                        </div>



                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                    <a href="#">cancel</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
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

            </div>

        </div>

    </section>
@endsection
