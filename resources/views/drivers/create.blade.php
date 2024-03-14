<?php
$page = 'driver';
?>
@extends('layouts.app')
@section('content')
    <style>
        .bulk {
            margin: 10px;
        }
    </style>
    <section class="content-header">
        <div class="back-button">
            <a href="{{ route('drivers.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    style="color:  #8C52FF;">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M1 9.60142C1 8.98705 1.54711 8.48901 2.22199 8.48901H16.4786C17.1535 8.48901 17.7006 8.98705 17.7006 9.60142C17.7006 10.2158 17.1535 10.7138 16.4786 10.7138H2.22199C1.54711 10.7138 1 10.2158 1 9.60142Z"
                        fill="#2D927E"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.2144 2.32582C10.6916 2.76024 10.6916 3.46457 10.2144 3.89899L3.95015 9.60144L10.2144 15.3039C10.6916 15.7383 10.6916 16.4426 10.2144 16.8771C9.73715 17.3115 8.96343 17.3115 8.48621 16.8771L1.35791 10.388C0.880695 9.95361 0.880695 9.24927 1.35791 8.81485L8.48621 2.32582C8.96343 1.89139 9.73715 1.89139 10.2144 2.32582Z"
                        fill="#2D927E"></path>
                </svg>
            </a>
            <h3>Add New Driver</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="guest-screen-left">

                    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="guest-screen-form">
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="col-lg-6 col-md-6 form-group">
                                <label>Driver Name</label>
                                <input type="text" name="name" placeholder="Name" class="form-control" required>
                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label>Mobile Number</label>
                                <input type="number" name="number" placeholder="Number" class="form-control" required>
                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Email" class="form-control" required>

                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Password" class="form-control" required>
                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label>License Plate Number</label>
                                <input type="text" name="license" placeholder="License" class="form-control"
                                    oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label for="roles">Business</label>
                                <select name="business" id="business" class="form-control">
                                    <option value="">Select a business</option>
                                    @foreach ($businesses as $business)
                                        <option value="{{ $business->business }}">{{ $business->business }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="add-btn" style="margin-right: 4rem;">
                <a href="{{ route('drivers.index') }}" class="btn cancel">
                    Cancel </a>
                <button type="submit" class="btn btn-success">Create Driver</button>
            </div>
            </form>
            <form action="{{ route('drivers.import') }}" method="POST" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="bulk">Add Record File</h4>
                {{-- <span>Data should not be repeated and have unique emails and Licence plate number</span> --}}
                <div class="col-lg-6 col-md-6 form-group">
                    <input type="file" name="file" placeholder="Add File" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Add record</button>
            </form>
        </div>
        <div class="col-4">
            <div class="row">
                <div
                    style="text-align: start; padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #f9f9f9;">
                    <p>Welcome! To upload a file, please follow these guidelines:</p>
                    <ul style="list-style-type: disc; margin-left: 20px;">
                        <li>We only accept Excel files (.xlsx, .xls).</li>
                        <li>Ensure your file adheres to our template to avoid any issues.</li>
                        <li>If you're uploading data, please ensure that the content is unique and doesn't repeat existing
                            entries.</li>
                    </ul>
                    <p>If you have any questions or face difficulties, feel free to reach out to our support team. Thank you
                        for your cooperation!</p>
                </div>
            </div>
            <div class="row mt-3">
                <a href="{{ route('download.template') }}" class="btn btn-primary">
                    Download Template
                </a>
            </div>
        </div>


    </section>
@endsection
