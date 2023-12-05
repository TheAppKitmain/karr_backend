<?php
$page = 'dash';
?>
@extends('layouts.app')
@section('content')
    <section class="support-screen">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="welcome-screen-left">
                    <div class="welcome-inner-content" style="display:flex;">
                        <center>
                            <h3>Fill this form to log into the system</h3>
                        </center>
                    </div>
                    <div class="welcome-inner-content">
                        <div class="col-md-6 col-md-offset-3" id="pay" style="margin-top:60px ">
                            <div class="panel panel-default credit-card-box">
                                <div class="panel-heading display-table" style="background-color:  #8C52FF; color:#fff;">
                                    <h3 class="panel-title" style="color: #fff"><strong>Payment Details</strong></h3>
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
                                    <form role="form" action="{{ route('user.subscription') }}" method="post"
                                        class="require-validation" data-cc-on-file="false"
                                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">

                                        @csrf
                                        <div class='form-row row'>

                                            <div class='col-xs-12 form-group required'>

                                                <label class='control-label'><b>Name on Card</b></label>
                                                <input name="name" id="card-name" type="text" class="form-control"
                                                    required></select>
                                            </div>

                                        </div>



                                        <div class='form-row row'>
                                            <div class='col-xs-12 form-group card required'>
                                                <label class='control-label'><b>Card Number</b></label>
                                                <input autocomplete='off' class='form-control card-number' size='20'
                                                    name="card" type='text' id="card-number" required>
                                            </div>

                                        </div>
                                        <div class='form-row row'>
                                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                <label class='control-label'><b>CVC</b></label>
                                                <input autocomplete='off' class='form-control card-cvc'
                                                    placeholder='ex. 311' size='4' type='text' id="card-cvc"
                                                    name="cvc">
                                            </div>
                                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                <label class='control-label'><b>Month</b></label>
                                                <input class='form-control card-expiry-month' placeholder='MM'
                                                 minlength="1" size="2" type='text' name="mon" id="card-expiry-month">
                                            </div>
                                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                <label class='control-label'><b>Expiration Year</b></label>
                                                <input class='form-control card-expiry-year' placeholder='YYYY'
                                                    size='4' type='text' name="year" id="card-expiry-year">
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


                                                <button class="btn btn-lg btn-block"
                                                    style="background-color:  #8C52FF; color:#fff" type="submit">
                                                    <strong>Submit</strong>

                                            </div>

                                        </div>



                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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

                        number: $('.card-number').val(),

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
@endsection
