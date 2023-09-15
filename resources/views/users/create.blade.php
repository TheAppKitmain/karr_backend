<?php
$page = 'user';
?>
@extends('layouts.app')
@section('content')
    <div id="userFormContainer">
        <section class="guest-screen">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="guest-screen-left">
                        <div class="guest-inner-content">
                            <h3>Create User</h3>
                        </div>
                        {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
                        <form action="{{ route('users.store') }}" method="POST">
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
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Email" class="form-control">
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
                                @can('role-list')
                                    <div class="form-group">
                                        <label>Roles</label>
                                        <input type="text" name="roles" value="Admin" readonly class="form-control">
                                    </div>
                                @endcan
                            </div>

                            <div class="row add-cancel-buttons">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="cancel-btn">
                                        <a href="{{route('users.index')}}">Back</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="add-btn">
                                        <button type="submit" class="btn btn-success">Add user</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12" id="quick-sticky">
                    <div class="guest-screen-right">
                        <div class="quick-review-contant">
                            <h3>Quick preview</h3>
                            <p>Create User and define role.</p>
                        </div>
                        <div class="quick-review-img">
                            <img src="{{ asset('assets/dist/img/thanks.jpg') }}">
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade create_success_property" create_success_property="" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content text-center">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <div class="header_inner">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70"
                                fill="none">
                                <path
                                    d="M25.0335 35.0772C25.7627 34.5304 26.7652 34.5304 27.4944 35.0772L31.5265 38.1013L35.0715 35.4426L28.1641 23.5117V15.9875H39.2383C40.046 15.9875 40.7787 15.5132 41.1093 14.7763C41.44 14.0392 41.3071 13.1768 40.7702 12.5735L38.7023 10.2495L40.7702 7.92586C41.3072 7.32252 41.44 6.45996 41.1093 5.72305C40.7787 4.986 40.046 4.51172 39.2383 4.51172H28.1641V4.375C28.1641 3.24242 27.2459 2.32422 26.1133 2.32422C24.9807 2.32422 24.0625 3.24242 24.0625 4.375V23.5117L17.2002 35.3646L20.9826 38.1154L25.0335 35.0772Z"
                                    fill="#2D927E"></path>
                                <path
                                    d="M32.757 42.3056C32.0277 42.8525 31.0253 42.8525 30.2961 42.3056L26.2639 39.2815L22.2318 42.3056C21.8675 42.5789 21.4345 42.7158 21.0014 42.7158C20.5782 42.7158 20.1549 42.5852 19.7952 42.3235L15.1342 38.9336L0.276036 64.5975C-0.0913271 65.232 -0.0918739 66.0142 0.274122 66.6494C0.640392 67.2846 1.3177 67.6758 2.05078 67.6758H53.684L37.141 39.0174L32.757 42.3056Z"
                                    fill="#F3D55B"></path>
                                <path
                                    d="M69.6742 64.516L49.9867 33.891C49.5992 33.288 48.9285 32.9318 48.2081 32.9499C47.4916 32.9686 46.8368 33.3602 46.4811 33.9825L42.7448 40.5209L58.4199 67.6758H67.9492C68.6994 67.6758 69.3897 67.2661 69.7493 66.6077C70.1087 65.9493 70.08 65.147 69.6742 64.516Z"
                                    fill="#F3D55B"></path>
                            </svg>
                            <h2>Created successfully!</h2>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>Good Job! "User"
                            <br>
                            has been created successfully.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" go-back btn btn-default" data-dismiss="modal">go back</button>
                        <button type="button" class="thanks-btn btn btn-default" data-dismiss="modal">ok
                            thanks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
