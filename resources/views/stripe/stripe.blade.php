@extends('layouts.app')


@section('styles')
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

    #card-errors {
        color: #f00;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 form-group">
                    <h2>Buy Now</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" id="payment-form" action="{{ url('stripe/purchase', $product->id) }}" class="card-form mt-3 mb-3">
                                @csrf
                                <input type="hidden" name="payment_method" class="payment-method">

                                <div class="form-group">
                                    <input id="card-holder-name" placeholder="Enter the Card Holder Name" type="text" class="form-control StripeElement">
                                </div>
    
                                <div class="form-group">
                                    <div id="card-element"></div>
                                </div>
                                
                                <button id="card-button" class="pay btn btn-primary">Process Payment</button>

                                <div id="card-errors" role="alert"></div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{$product->image}}" alt="" style="width:100px">
                            <p>{{$product->name}}</p>
                            <p>Price : ₹ {{$product->price}}</p>
                            <p>{{$product->description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        let stripe = Stripe("{{ env('STRIPE_KEY') }}");
        let elements = stripe.elements();
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
        let card = elements.create('card', {style: style});
        card.mount('#card-element');
        let paymentMethod = null;
        $('.card-form').on('submit', function (e) {
            e.preventDefault();
            $('button.pay').attr('disabled', true);
            let cardHolderName = $('#card-holder-name').val();

            $('#card-errors').text('');

            if(cardHolderName && cardHolderName != '') {
                $('#card-holder-name').removeClass('StripeElement--invalid');

                if (paymentMethod) {
                    return true;
                }

                stripe.confirmCardSetup(
                    "{{ $intent->client_secret }}",
                    {
                        payment_method: {
                            card: card,
                            billing_details: {name: cardHolderName}
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        $('#card-errors').text(result.error.message);
                        $('button.pay').removeAttr('disabled');
                    } else {
                        paymentMethod = result.setupIntent.payment_method;
                        $('.payment-method').val(paymentMethod);
                        $(this).unbind(e);
                        $('.card-form').submit();
                    }
                });
                return false;
            } else {
                $('button.pay').removeAttr('disabled');
                $('#card-holder-name').addClass('StripeElement--invalid');
                $('#card-errors').text('Enter the Card Holder Name');
            }
        });
        

    </script>
@endsection