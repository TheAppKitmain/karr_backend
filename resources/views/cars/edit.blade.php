<?php
$page = 'car';
?>
@extends('layouts.app')
@section('content')
<section class="profile-screen">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="welcome-screen-left">
                <div class="welcome-inner-content">
                    <h3>edit car details</h3>
                </div>
                <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="welcome-screen-form">
                        <div class="form-group">
                            <label>Vehicle Make</label>
                            <input type="text" name="make" placeholder="Make" class="form-control" value="{{$car->make}}">
                        </div>
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" placeholder="Number" class="form-control" value="{{$car->number}}">
                        </div>
                        <div class="form-group">
                            <label>Year of Manufacture</label>
                            <input type="number" name="year" placeholder="Year of Manufacture" class="form-control" value="{{$car->year}}">

                        </div>
                        <div class="form-group">
                            <label>Date of Registeration</label>
                            <input type="date" name="dor" placeholder="Date of Registeration"
                                class="form-control" value="{{$car->dor}}">
                        </div>
                        <div class="form-group">
                            <label>Cylinder Capacity</label>
                            <input type="text" name="capacity" placeholder="Cylinder Capacity" class="form-control" value="{{$car->capacity}}">
                        </div>
                        <div class="form-group">
                            <label>CO2 Emission</label>
                            <input type="text" name="co" placeholder="CO2 Emissions" class="form-control" value="{{$car->co}}">
                        </div>
                        <div class="form-group">
                            <label>Export Maker</label>
                            <input type="text" name="export" placeholder="CO2 Emission" class="form-control" value="{{$car->export}}">
                        </div>
                        <div class="form-group">
                            <label>Fuel Type</label>
                            <input type="text" name="fuel" placeholder="Fuel Type" class="form-control" value="{{$car->fuel}}">
                        </div>
                        <div class="form-group">
                            <label>Real Driving Emissions</label>
                            <input type="text" name="rde" placeholder="Real Driving Emissions"
                                class="form-control" value="{{$car->rde}}">
                        </div>
                        <div class="form-group">
                            <label>Euro Status</label>
                            <input type="text" name="euro" placeholder="Yes or No" class="form-control" value="{{$car->euro}}">

                        </div>
                        <div class="form-group">
                            <label>Vehicle Status</label>
                            <input type="text" name="status" placeholder="Taxed or Not Taxed" class="form-control" value="{{$car->status}}">
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
                                <button type="submit" class="btn btn-success">Save changes</button>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="welcome-screen-right">
                <div class="quick-review-contant">
                    <h3>Change Image</h3>
                </div>
                <div class="welcome-screen-form">
                    <img id="image-preview" src="{{asset('image/'.$car->image) }}" height="200px" alt="Image Preview">
                    <input type="file" name="image" id="image" accept="image/*" class="form-control">
                </div>
            </div>
            </form>
        </div>

    </div>

</section>
@endsection
