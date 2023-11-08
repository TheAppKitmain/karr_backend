<?php
$page = 'tolls';
?>
@extends('layouts.app')
@section('content')
    <style>
        .home {
            float: left;
            margin: 5px;
            width: 150px;
            border-radius: 10px;
            height: 50px;
            background: #FBFBFB;
        }

        .homeChange {

            background: #8C52FF;
            color: white;

        }
    </style>
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content" style="display:flex;  justify-content: start;">
                        <button id="tollBtn" class="home">
                            Toll
                        </button>
                        <button id="chargeBtn" class="home">
                            Charges
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="create-services-screen" style="margin-top:10px ">
        <div class="row create-services-screen-left">
            <div class="for-our-services">
                <a href="{{ route('toll.create') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <mask id="path-1-inside-1_105_1242" fill="white">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.33325 18.3333C8.33325 19.255 9.07992 20 9.99992 20C10.9199 20 11.6666 19.255 11.6666 18.3333V11.6667H18.3333C19.2533 11.6667 20 10.92 20 10C20 9.08001 19.2533 8.33334 18.3333 8.33334H11.6666V1.66667C11.6666 0.746667 10.9199 0 9.99992 0C9.07992 0 8.33325 0.746667 8.33325 1.66667V8.33334H1.66667C0.745 8.33334 0 9.08001 0 10C0 10.92 0.745 11.6667 1.66667 11.6667H8.33325V18.3333Z" />
                        </mask>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.33325 18.3333C8.33325 19.255 9.07992 20 9.99992 20C10.9199 20 11.6666 19.255 11.6666 18.3333V11.6667H18.3333C19.2533 11.6667 20 10.92 20 10C20 9.08001 19.2533 8.33334 18.3333 8.33334H11.6666V1.66667C11.6666 0.746667 10.9199 0 9.99992 0C9.07992 0 8.33325 0.746667 8.33325 1.66667V8.33334H1.66667C0.745 8.33334 0 9.08001 0 10C0 10.92 0.745 11.6667 1.66667 11.6667H8.33325V18.3333Z"
                            fill="white" />
                        <path
                            d="M11.6666 11.6667V11.2667H11.2666V11.6667H11.6666ZM11.6666 8.33334H11.2666V8.73334H11.6666V8.33334ZM8.33325 8.33334V8.73334H8.73325V8.33334H8.33325ZM8.33325 11.6667H8.73325V11.2667H8.33325V11.6667ZM9.99992 19.6C9.30057 19.6 8.73325 19.0338 8.73325 18.3333H7.93325C7.93325 19.4762 8.85927 20.4 9.99992 20.4V19.6ZM11.2666 18.3333C11.2666 19.0338 10.6993 19.6 9.99992 19.6V20.4C11.1406 20.4 12.0666 19.4762 12.0666 18.3333H11.2666ZM11.2666 11.6667V18.3333H12.0666V11.6667H11.2666ZM18.3333 11.2667H11.6666V12.0667H18.3333V11.2667ZM19.6 10C19.6 10.6991 19.0324 11.2667 18.3333 11.2667V12.0667C19.4742 12.0667 20.4 11.1409 20.4 10H19.6ZM18.3333 8.73334C19.0324 8.73334 19.6 9.30092 19.6 10H20.4C20.4 8.8591 19.4742 7.93334 18.3333 7.93334V8.73334ZM11.6666 8.73334H18.3333V7.93334H11.6666V8.73334ZM11.2666 1.66667V8.33334H12.0666V1.66667H11.2666ZM9.99992 0.4C10.699 0.4 11.2666 0.967581 11.2666 1.66667H12.0666C12.0666 0.525753 11.1408 -0.4 9.99992 -0.4V0.4ZM8.73325 1.66667C8.73325 0.967581 9.30083 0.4 9.99992 0.4V-0.4C8.859 -0.4 7.93325 0.525753 7.93325 1.66667H8.73325ZM8.73325 8.33334V1.66667H7.93325V8.33334H8.73325ZM1.66667 8.73334H8.33325V7.93334H1.66667V8.73334ZM0.4 10C0.4 9.30066 0.966174 8.73334 1.66667 8.73334V7.93334C0.523826 7.93334 -0.4 8.85936 -0.4 10H0.4ZM1.66667 11.2667C0.966174 11.2667 0.4 10.6994 0.4 10H-0.4C-0.4 11.1407 0.523826 12.0667 1.66667 12.0667V11.2667ZM8.33325 11.2667H1.66667V12.0667H8.33325V11.2667ZM8.73325 18.3333V11.6667H7.93325V18.3333H8.73325Z"
                            fill="#2D927E" mask="url(#path-1-inside-1_105_1242)" />
                    </svg>
                    Create New Tolls
                </a>
                <a href="{{ route('charges.create') }}"><svg width="20" height="20" viewBox="0 0 20 20"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="path-1-inside-1_105_1242" fill="white">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.33325 18.3333C8.33325 19.255 9.07992 20 9.99992 20C10.9199 20 11.6666 19.255 11.6666 18.3333V11.6667H18.3333C19.2533 11.6667 20 10.92 20 10C20 9.08001 19.2533 8.33334 18.3333 8.33334H11.6666V1.66667C11.6666 0.746667 10.9199 0 9.99992 0C9.07992 0 8.33325 0.746667 8.33325 1.66667V8.33334H1.66667C0.745 8.33334 0 9.08001 0 10C0 10.92 0.745 11.6667 1.66667 11.6667H8.33325V18.3333Z" />
                        </mask>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.33325 18.3333C8.33325 19.255 9.07992 20 9.99992 20C10.9199 20 11.6666 19.255 11.6666 18.3333V11.6667H18.3333C19.2533 11.6667 20 10.92 20 10C20 9.08001 19.2533 8.33334 18.3333 8.33334H11.6666V1.66667C11.6666 0.746667 10.9199 0 9.99992 0C9.07992 0 8.33325 0.746667 8.33325 1.66667V8.33334H1.66667C0.745 8.33334 0 9.08001 0 10C0 10.92 0.745 11.6667 1.66667 11.6667H8.33325V18.3333Z"
                            fill="white" />
                        <path
                            d="M11.6666 11.6667V11.2667H11.2666V11.6667H11.6666ZM11.6666 8.33334H11.2666V8.73334H11.6666V8.33334ZM8.33325 8.33334V8.73334H8.73325V8.33334H8.33325ZM8.33325 11.6667H8.73325V11.2667H8.33325V11.6667ZM9.99992 19.6C9.30057 19.6 8.73325 19.0338 8.73325 18.3333H7.93325C7.93325 19.4762 8.85927 20.4 9.99992 20.4V19.6ZM11.2666 18.3333C11.2666 19.0338 10.6993 19.6 9.99992 19.6V20.4C11.1406 20.4 12.0666 19.4762 12.0666 18.3333H11.2666ZM11.2666 11.6667V18.3333H12.0666V11.6667H11.2666ZM18.3333 11.2667H11.6666V12.0667H18.3333V11.2667ZM19.6 10C19.6 10.6991 19.0324 11.2667 18.3333 11.2667V12.0667C19.4742 12.0667 20.4 11.1409 20.4 10H19.6ZM18.3333 8.73334C19.0324 8.73334 19.6 9.30092 19.6 10H20.4C20.4 8.8591 19.4742 7.93334 18.3333 7.93334V8.73334ZM11.6666 8.73334H18.3333V7.93334H11.6666V8.73334ZM11.2666 1.66667V8.33334H12.0666V1.66667H11.2666ZM9.99992 0.4C10.699 0.4 11.2666 0.967581 11.2666 1.66667H12.0666C12.0666 0.525753 11.1408 -0.4 9.99992 -0.4V0.4ZM8.73325 1.66667C8.73325 0.967581 9.30083 0.4 9.99992 0.4V-0.4C8.859 -0.4 7.93325 0.525753 7.93325 1.66667H8.73325ZM8.73325 8.33334V1.66667H7.93325V8.33334H8.73325ZM1.66667 8.73334H8.33325V7.93334H1.66667V8.73334ZM0.4 10C0.4 9.30066 0.966174 8.73334 1.66667 8.73334V7.93334C0.523826 7.93334 -0.4 8.85936 -0.4 10H0.4ZM1.66667 11.2667C0.966174 11.2667 0.4 10.6994 0.4 10H-0.4C-0.4 11.1407 0.523826 12.0667 1.66667 12.0667V11.2667ZM8.33325 11.2667H1.66667V12.0667H8.33325V11.2667ZM8.73325 18.3333V11.6667H7.93325V18.3333H8.73325Z"
                            fill="#2D927E" mask="url(#path-1-inside-1_105_1242)" />
                    </svg>
                    Create New Charges
                </a>
            </div>

            <div class="scroll" id="AllTable">
                <table class="table" id="table">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th>Name</th>
                            <th>Days</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tolls as $key => $toll)
                            <tr>
                                <td>{{ $toll->name }}</td>
                                <td>{{ implode(', ', $toll->days) }}</td>
                                <td>Toll</td>
                                <td>£ {{ number_format($toll->price, 2) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('toll.edit', $toll->id) }}">Update</a>

                                </td>
                                <td>
                                    <form action="{{ route('toll.destroy', $toll->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($charges as $key => $charge)
                            <tr>
                                <td>{{ $charge->area }}</td>
                                <td>{{ $charge->time }}</td>
                                <td>Charges</td>
                                <td>£ {{ number_format($charge->price, 2) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('charges.edit', $charge->id) }}">Update</a>

                                </td>
                                <td>
                                    <form action="{{ route('charges.destroy', $charge->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="scroll" id="charge" style="display: none;">
                <table class="table" id="table">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th>Name</th>
                            <th>Days</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Update</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($charges as $key => $charge)
                            <tr>
                                <td>{{ $charge->area }}</td>
                                <td>{{ $charge->city }}</td>
                                <td>Charges</td>
                                <td>£ {{ number_format($charge->price, 2) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('charges.edit', $charge->id) }}">Update</a>

                                </td>
                                <td>
                                    <form action="{{ route('charges.destroy', $charge->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="scroll" id="toll" style="display: none;">
                <table class="table" id="table">
                    <thead>
                        <tr style="background-color: #F8F8FA">
                            <!-- Define the table headers -->
                            <th>Name</th>
                            <th>Days</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Update</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tolls as $key => $toll)
                        <tr>
                            <td>{{ $toll->name }}</td>
                            <td>{{ implode(', ', $toll->days) }}</td>
                            <td>Toll</td>
                            <td>£ {{ number_format($toll->price, 2) }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('toll.edit', $toll->id) }}">Update</a>

                            </td>
                            <td>
                                <form action="{{ route('toll.destroy', $toll->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </section>
    <script>
        $(document).ready(function() {
            $("#tollBtn").click(function() {
                $(this).addClass('homeChange');
                $("#chargeBtn").removeClass('homeChange');
                $("#toll").show();
                $("#charge").hide();
                $("#AllTable").hide();
            });


            $("#chargeBtn").click(function() {
                $(this).addClass('homeChange');
                $("#tollBtn").removeClass('homeChange');
                $("#charge").show();
                $("#toll").hide();
                $("#AllTable").hide();
            });

        });
    </script>
@endsection
