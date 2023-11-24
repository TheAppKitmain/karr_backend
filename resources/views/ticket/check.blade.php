<!-- Your Blade view file -->

@extends('layouts.app')

@section('content')
    <div>
        <!-- Your other HTML content -->

        <button id="applePayButton" class="apple-pay-button"></button>

        <form role="form" action="{{ route('payment', $type->id) }}" method="post" class="require-validation"
            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">

            <!-- Your existing form content -->

            @csrf

            <!-- Add a hidden input to store the Apple Pay paymentMethodId -->
            <input type="hidden" name="paymentMethodId" id="paymentMethodId">

            <!-- Your existing form content -->

            <div class="row">
                <div class="col-xs-12">
                    <input type="hidden" value="{{ $price }}" name="price">
                    <input type="hidden" name="type" value="{{ $name }}">
                    <button class="btn btn-lg btn-block" style="background-color: #8C52FF; color:#fff" type="submit">
                        <strong>Pay Now ({{ $price }} £) </strong>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');

            var elements = stripe.elements();
            var prButton = elements.create('paymentRequestButton', {
                paymentRequest: stripe.paymentRequest({
                    country: 'UK',
                    currency: 'gpb',
                    total: {
                        label: 'Your Label',
                        amount: 1000, // Amount in cents
                    },
                    requestPayerName: true,
                    requestPayerEmail: true,
                }),
            });

            // Check the availability of the Payment Request API
            prButton.canMakePayment().then(function (result) {
                if (result) {
                    document.getElementById('applePayButton').style.display = 'block';
                    prButton.mount('#applePayButton');
                } else {
                    document.getElementById('applePayButton').style.display = 'none';
                }
            });

            prButton.on('paymentmethod', function (ev) {
                // Set the paymentMethodId in the hidden input
                document.getElementById('paymentMethodId').value = ev.paymentMethod.id;
            });

            var $form = $(".require-validation");

            $form.on('submit', function (e) {
                e.preventDefault();

                if (document.getElementById('paymentMethodId').value) {
                    // Apple Pay was used, submit the form
                    $form.get(0).submit();
                } else {
                    // Handle Stripe payment as before
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            // Stripe Response Handler function remains the same as before
            function stripeResponseHandler(status, response) {
                // Your existing stripeResponseHandler code
            }
        });
    </script>
@endsection
