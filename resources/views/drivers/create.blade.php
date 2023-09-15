<?php
$page = 'driver';
?>
@extends('layouts.app')
@section('content')
    <section class="guest-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="guest-screen-left">
                    <div class="guest-inner-content">
                        <h3>Create Driver</h3>
                    </div>

                    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="guest-screen-form">
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Number</label>
                                <input type="number" name="number" placeholder="Number" class="form-control">

                            </div>
                            <div class="form-group">
                                <label>License</label>
                                <input type="text" name="license" placeholder="License" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Password" class="form-control">
                            </div>



                        </div>

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                    <a href="{{ route('drivers.index') }}" style="color: white" class="btn btn-primary">
                                        Back </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Add Driver</button>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12" id="quick-sticky">
                <div class="guest-screen-right">
                    <div class="quick-review-contant">
                        <h3>Quick preview</h3>
                        <p>Create Driver.</p>
                    </div>
                    <div class="quick-review-img">

                        <label>Image</label>
                        <img id="image-preview" src="#" alt="Image Preview">
                        <input type="file" name="image" id="image" accept="image/*" class="form-control"
                            onchange="previewImage()">

                    </div>
                </div>
            </div>
            </form>

        </div>
        <script>
            function previewImage() {
                var fileInput = document.getElementById('image');
                var imagePreview = document.getElementById('image-preview');

                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };

                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        </script>
    </section>
@endsection
