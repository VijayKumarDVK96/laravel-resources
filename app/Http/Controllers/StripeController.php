<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

// composer require laravel/cashier

// composer require laravel/ui --dev
// php artisan ui:auth

// php artisan make:factory ProductFactory --model=Product
// php artisan db:seed

class StripeController extends Controller {

    function products() {
        $data['products'] = Product::all();
        return view('stripe/products', $data);
    }

    function stripe($id) {
        $data['product'] = Product::find($id);
        $data['intent'] = auth()->user()->createSetupIntent();
        return view('stripe/stripe', $data);
    }

    public function purchase(Request $request) {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $product = Product::find($request->id);

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $data = $user->charge($product->price * 100, $paymentMethod);

            if($data->status == 'succeeded') {
                return redirect('stripe/complete')->with('message', 'Payment done, Product purchased successfully!');
            } else {
                return redirect('stripe/complete')->with('error', 'Payment unsuccessful');
            }
            
        } catch (\Exception $exception) {
            return redirect('stripe/complete')->with('error', $exception->getMessage());
        }
    }
}
