<?php
$page = 'car';
?>
@extends('layouts.app')
@section('content')
<style>
    .quick-review-img {
        text-align: center;
    }
    #image-preview {
        max-width: 100%;
        max-height: 200px;
    }
</style>
    <section class="guest-screen">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="guest-screen-left">
                    <div class="guest-inner-content">
                        <h3>Create Car</h3>
                    </div>
                    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="guest-screen-form">
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Vehicle Make</label>
                                <input type="text" name="make" placeholder="Make" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Number</label>
                                <input type="text" name="number" placeholder="Number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Year of Manufacture</label>
                                <input type="number" name="year" placeholder="Year of Manufacture" class="form-control">

                            </div>
                            <div class="form-group">
                                <label>Date of Registeration</label>
                                <input type="date" name="dor" placeholder="Date of Registeration"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Cylinder Capacity</label>
                                <input type="text" name="capacity" placeholder="Cylinder Capacity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>CO2 Emission</label>
                                <input type="text" name="co" placeholder="CO2 Emissions" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Export Maker</label>
                                <input type="text" name="export" placeholder="Yes or No" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Fuel Type</label>
                                <input type="text" name="fuel" placeholder="Fuel Type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Real Driving Emissions</label>
                                <input type="text" name="rde" placeholder="Real Driving Emissions"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Euro Status</label>
                                <input type="text" name="euro" placeholder="Yes or No" class="form-control">

                            </div>
                            <div class="form-group">
                                <label>Vehicle Status</label>
                                <input type="text" name="status" placeholder="Taxed or Not Taxed" class="form-control">
                            </div>

                        </div>

                        <div class="row add-cancel-buttons">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="cancel-btn">
                                    <button type="submit" class="btn btn-primary"> Back </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="add-btn">
                                    <button type="submit" class="btn btn-success">Add Car</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12" id="quick-sticky">
                <div class="guest-screen-right">
                    <div class="quick-review-contant">
                        <h3>Quick preview</h3>
                        <p>Create Car.</p>
                    </div>
                    <div class="quick-review-img">
                       
                        <label>Image</label>
                        <img id="image-preview" src="#" alt="Image Preview">
                        <input type="file" name="image" id="image" accept="image/*" class="form-control" onchange="previewImage()">
                    
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
    <script>
        function previewImage() {
            var fileInput = document.getElementById('image');
            var imagePreview = document.getElementById('image-preview');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
@endsection
