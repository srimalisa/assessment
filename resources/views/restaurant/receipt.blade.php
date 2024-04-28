@extends('layouts.skote.receipt-layout')

@section('content')

<div class="main-content">
    <div class="page-section bg-danger border-bottom-white mt-5 pt-5 pb-5">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
            <img src="{{asset('public/images/illustration/student/128/white.svg')}}" width="104" class="mr-md-32pt mb-32pt mb-md-0" alt="student"> 
            <div class="flex mb-32pt mb-md-0">
                <h2 class="text-white mb-0">Order #{{ $order->id }}</h2>
             </div>
        </div>
    </div>
<div class="page-section border-bottom-2 bg-white pt-4">
        <div class="container page__container">
            <div class="row">
                <div class="col-lg-7">
                    <h3 class="mb-3">Payment Successful</h3>
                </div>
                <div class="container mt-5 mb-5">
                    <div class="d-flex justify-content-center row">
                        <div class="col-md-10">
                            <div class="receipt bg-white p-3 rounded">
                                <h4 class="mt-2 mb-3">Your order is confirmed!</h4>
                                <h6 class="name">Hello {{ Auth::user('name') }},</h6><span class="fs-12 text-black-50">Your payment has been confirmed</span>
                                <hr>
                                <div class="d-flex flex-row justify-content-between align-items-center order-details">
                                    <div><span class="d-block fs-12">Payment date</span><span class="font-weight-bold">{{ Carbon\Carbon::parse($order->payment_date)->format('jS F Y') }}</span></div>
                                    <div><span class="d-block fs-12">Payment ID</span><span class="font-weight-bold">{{ $order->payment_id }}</span></div>
                                </div>
                                <hr>
                                @foreach($order->orderDetails as $detail)
                                <div class="d-flex justify-content-between align-items-center product-details">
                                    <div class="d-flex flex-column justify-content-between ml-2">
                                        <div>
                                            <span class="d-block font-weight-bold p-name">{{ isset($detail->food->name) ? $detail->food->name : '' }}</span>
                                            <span class="fs-12">Category: {{ isset($order->restaurant->category->name) ? $order->restaurant->category->name : '' }}</span></div>
                                            <span class="fs-12">Qty: {{ $detail->quantity }}</span>
                                        </div>
                                    <div class="product-price">
                                        <h5>MYR {{ $detail->total_price }}</h5>
                                    </div>
                                </div>
                                @endforeach
                                <div class="mt-5 amount row">
                                    <div class="d-flex justify-content-center col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="billing">
                                            <div class="d-flex justify-content-between mt-1"><span class="font-weight-bold">Total</span><span class="font-weight-bold text-success">MYR {{ $order->total_price }}</span></div>
                                        </div>
                                    </div>
                                </div>
                                <span class="d-block mt-3 text-black-50 fs-15">Restaurant is making your order</span>
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary">Back</a>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')
@endsection