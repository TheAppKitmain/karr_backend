<?php
$page = 'fine';
?>
@extends('layouts.app')
@section('content')
<!-- Add this to your HTML file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <section class="create-services-screen">
        <div class="row create-services-screen-left">

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
            <div class="scroll" id="AllTable">
                <table class="table" id="Alltable">
                    <h4 style="margin-bottom: 10px">Undetected Fines</h4>
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th>Image</th>
                            <th>Name of Business</th>
                            <th>Driver</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fines as $key => $fine)
                            <tr>
                                <td>
                                    <a href="{{ asset($fine->image) }}" data-fancybox="gallery">
                                        <img src="{{ asset($fine->image) }}" width="100" height="80" alt="User Image">
                                    </a>
                                </td>
                                <td>{{ $fine->driver->name }}</td>
                                <td>{{ $fine->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
