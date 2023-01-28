@extends('layouts.app')

@section('styles')
    <style>
        .card {
            height: 360px;
        }
    </style>
@endsection

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 form-group">
                    <h2>Products</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse ($products as $product)
                    <div class="col-md-4 form-group">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{$product->image}}" alt="" style="width:100px">
                                <p>{{$product->name}}</p>
                                <p>Price : ₹ {{$product->price}}</p>

                                <a href="{{url('stripe/product', $product->id)}}" class="btn btn-primary form-group">Buy Now</a>

                                <p>{{$product->description}}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p>No Products Available</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection