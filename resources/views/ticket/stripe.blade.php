<?php
$page = 'ticket';
?>

@extends('layouts.app')
@section('content')
    <script src="https://use.fontawesome.com/releases/v5.7.2/css/all.css"></script>
    <style>
        .button-clicked {
            background-color: #8C52FF;
            color: white;
            border: 1px solid black;
            /* height: 30px; */
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="row">
        <section class="create-services-screen">
            <button id="addButton" class="justify-content-start btn-lg">
                ADD CARD
            </button>
            <button id="payButton" class="justify-content-start btn-lg">
                PAYMENT
            </button>
            <div class="row create-services-screen-left">
                {{-- -------------------------------------Stripe Payment form ---------------------------- --}}
                <div class="col-md-6 col-md-offset-3" id="pay" style="margin-top:60px ">
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table" style="background-color:  #8C52FF; color:#fff">
                            <h3 class="panel-title"><strong>Payment Details</strong></h3>
                        </div>
                        <div class="panel-body">

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
                            <form role="form" action="{{ route('payment', $type->id) }}" method="post"
                                class="require-validation" data-cc-on-file="false"
                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">

                                @csrf



                                <div class='form-row row'>

                                    <div class='col-xs-12 form-group required'>

                                        <label class='control-label'><b>Name on Card</b></label>
                                        <select name="name" id="card-name" class="form-control">
                                            <option value="">---Select Values---</option>
                                            @foreach ($collection as $item)
                                                <option value="{{ $item->name }}" data-card-number="{{ $item->card }}"
                                                    data-card-cvc="{{ $item->cvc }}"
                                                    data-card-expiry-month="{{ $item->mon }}"
                                                    data-card-expiry-year="{{ $item->year }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                </div>



                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group card required'>
                                        <label class='control-label'><b>Card Number</b></label>
                                        <input autocomplete='off' class='form-control card-number' size='20'
                                            type='text' id="card-number" readonly>
                                    </div>
                                    <input type="hidden" name="card-number-hidden" class="card-number-hidden" id="card-number-hidden">
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'><b>CVC</b></label>
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                            size='4' type='text' id="card-cvc" readonly>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'><b>Expiration Month</b></label>
                                        <input class='form-control card-expiry-month' placeholder='MM' size='2'
                                            type='text' id="card-expiry-month" readonly>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'><b>Expiration Year</b></label>
                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                            type='text' id="card-expiry-year" readonly>
                                    </div>
                                </div>




                                <div class='form-row row'>

                                    <div class='col-md-12 error form-group hide'>

                                        <div class='alert-danger alert'>Please correct the errors and try

                                            again.</div>

                                    </div>

                                </div>



                                <div class="row">

                                    <div class="col-xs-12">

                                        <input type="hidden" value="{{ $price }}" name="price">
                                        <input type="hidden" name="type" value="{{ $name }}">
                                        <button class="btn btn-lg btn-block" style="background-color:  #8C52FF; color:#fff"
                                            type="submit"> <strong>Pay Now
                                                ({{ $price }}
                                                £) </strong></button>

                                    </div>

                                </div>



                            </form>
                        </div>
                    </div>

                </div>
                {{-- ----------------------------- End stripe Form---------------------------------------- --}}
                {{-- -------------------------------------Add Card --------------------------------------- --}}
                <div class="row d-flex justify-content-center" id="add" style="display: none;">
                    <div class="col-md-10 col-lg-8 col-xl-5">
                        <div class="card rounded-3">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <h3>Settings</h3>
                                    <h6>Payment</h6>
                                </div>
                                <form action="{{ route('card') }}" method="post">
                                    @csrf
                                    <h4 class="mb-2">Add new Card</h4>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="formControlLgXsd">Cardholder's Name</label>
                                        <input type="text" id="formControlLgXsd" class="form-control form-control-lg"
                                            placeholder="Anna Doe" name="name" />
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-7">
                                            <div class="form-outline">
                                                <label class="form-label" for="formControlLgXM">Card Number</label>
                                                <input type="text" id="formControlLgXM"
                                                    class="form-control form-control-lg" placeholder="1234 5678 1234 5678"
                                                    name="card" maxlength="20" />
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-outline">
                                                <label class="form-label" for="formControlLgExpk">Expire Month</label>
                                                <input type="test" id="formControlLgExpk"
                                                    class="form-control form-control-lg" placeholder="MM" maxlength="2"
                                                    name="mon" />
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="formControlLgExpk">Expire Year</label>
                                                <input type="test" id="formControlLgExpk"
                                                    class="form-control form-control-lg" placeholder="YYYY"
                                                    maxlength="4" name="year" min="2020" />
                                            </div>
                                        </div>
                                        <div class="col-2 mb-3">
                                            <div class="form-outline">
                                                <label class="form-label" for="formControlLgcvv">Cvc</label>
                                                <input type="integer" id="formControlLgcvv"
                                                    class="form-control form-control-lg" placeholder="Cvc" name="cvc"
                                                    maxlength="4" />
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-success btn-lg btn-block"
                                        style="background-color: #8C52FF; border: none;">Add card</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------------------------------- End Add Card ---------------------------------- --}}
            </div>
        </section>

        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

        <script type="text/javascript">
            $(function() {

                /*------------------------------------------

                --------------------------------------------

                Stripe Payment Code

                --------------------------------------------

                --------------------------------------------*/

                var $form = $(".require-validation");



                $('form.require-validation').bind('submit', function(e) {

                    var $form = $(".require-validation"),

                        inputSelector = ['input[type=email]', 'input[type=password]',

                            'input[type=text]', 'input[type=file]',

                            'textarea'
                        ].join(', '),

                        $inputs = $form.find('.required').find(inputSelector),

                        $errorMessage = $form.find('div.error'),

                        valid = true;

                    $errorMessage.addClass('hide');



                    $('.has-error').removeClass('has-error');

                    $inputs.each(function(i, el) {

                        var $input = $(el);

                        if ($input.val() === '') {

                            $input.parent().addClass('has-error');

                            $errorMessage.removeClass('hide');

                            e.preventDefault();

                        }

                    });



                    if (!$form.data('cc-on-file')) {

                        e.preventDefault();

                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));

                        Stripe.createToken({

                            number: $('.card-number-hidden').val(),

                            cvc: $('.card-cvc').val(),

                            exp_month: $('.card-expiry-month').val(),

                            exp_year: $('.card-expiry-year').val()

                        }, stripeResponseHandler);

                    }



                });



                /*------------------------------------------

                --------------------------------------------

                Stripe Response Handler

                --------------------------------------------

                --------------------------------------------*/

                function stripeResponseHandler(status, response) {

                    if (response.error) {

                        $('.error')

                            .removeClass('hide')

                            .find('.alert')

                            .text(response.error.message);

                    } else {

                        /* token contains id, last4, and card type */

                        var token = response['id'];



                        $form.find('input[type=text]').empty();

                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

                        $form.get(0).submit();

                    }

                }



            });
        </script>

        <script>
            $(document).ready(function() {
                $("#payButton").click(function() {
                    // Add the CSS class to the clicked button
                    $(this).addClass('button-clicked');

                    // Remove the CSS class from the other button
                    $("#addButton").removeClass('button-clicked');

                    // Show/hide elements as needed
                    $("#pay").show();
                    $("#add").hide();
                });

                $("#addButton").click(function() {
                    // Add the CSS class to the clicked button
                    $(this).addClass('button-clicked');

                    // Remove the CSS class from the other button
                    $("#payButton").removeClass('button-clicked');

                    // Show/hide elements as needed
                    $("#add").show();
                    $("#pay").hide();
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Add a change event listener to the dropdown
                $('#card-name').change(function() {
                    // Get the selected option
                    var selectedOption = $(this).find('option:selected');

                    // Get the full card number as a string
                    var fullCardNumber = String(selectedOption.data('card-number'));

                    // Get only the last four digits
                    var lastFourDigits = fullCardNumber.slice(-4);

                    // Mask the card number and update the input field
                    var maskedCardNumber = '************' + lastFourDigits;
                    $('#card-number').val(maskedCardNumber);
                    $('#card-number-hidden').val(selectedOption.data('card-number'));;
                    // Populate the card details based on the selected option's data attributes
                    $('#card-cvc').val(selectedOption.data('card-cvc'));
                    $('#card-expiry-month').val(selectedOption.data('card-expiry-month'));
                    $('#card-expiry-year').val(selectedOption.data('card-expiry-year'));
                });
            });
        </script>
    @endsection
