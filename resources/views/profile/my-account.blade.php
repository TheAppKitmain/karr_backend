<?php
$page = 'account';
?>
@extends('layouts.app')
@section('content')
    <section class="profile-screen">
        <div class="row">
            <form action="{{ route('user.cancel', Auth::user()->id)}}" method="POST">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="welcome-screen-left">
                        <div class="welcome-inner-content">
                            <h3>Account Details</h3>
                            <p>You can cancel your subscription any time</p>
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
                        <div class="welcome-screen-form">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name"
                                    value="{{ $user->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email"
                                    value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Card Number</label>
                                <input  class="form-control" name="card" value="{{$user->card}}" readonly>
                            </div>
                        </div>

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">

                                    <a href="#">cancel</a>

                                    <button type="submit" class="btn btn-primary">Cancel Subscription</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">

                </div>
            </form>

        </div>

    </section>
@endsection
