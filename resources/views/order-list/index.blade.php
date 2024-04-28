@extends('layouts.skote.master-layouts')

@section('content')
<style>
    .food-card {
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .food-card.selected {
        transform: scale(1.1);
        border: 1px solid blue;
    }
</style>

<div class="main-content">
    <div class="page-section bg-danger border-bottom-white mt-5 pt-5 pb-5">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-md-left mt-5">
            <i class="fa fa-fw fa-shopping-cart text-white fa-5x"></i>
            <div class="flex mb-32pt mb-md-0">
                <h2 class="text-white mb-0">Order</h2>
            </div>
        </div>
    </div>
    <div class="page-section border-bottom-2 bg-white pt-4">
        <div class="container page__container">
            <div class="row">
                <table class="table table-bordered table-striped">
                    <tr class="text-center">
                        <td>Order ID</td>
                        <td>Restaurant</td>
                        <td>Delivery Type</td>
                        <td>Order Status</td>
                        <td>Payment Status</td>
                        <td>Total</td>
                        <td>Order Item</td>
                        <td>Action</td>
                    </tr>
                    @foreach ($order as $orders)
                        <tr>
                            <td>{{ $orders['id'] }}</td>
                            <td>{{ isset($orders['restaurant']['name']) ? $orders['restaurant']['name'] : '' }}</td>
                            <td>{{ isset($orders['delivery_type']['name']) ? $orders['delivery_type']['name'] : '' }}</td>
                            <td>{{ isset($orders['order_status']['name']) ? $orders['order_status']['name'] : '' }}</td>
                            <td>{{ isset($orders['payment']['payment_status']) ? $orders['payment']['payment_status'] : 'Pending' }}</td>
                            <td>{{ $orders['total_price'] }}</td>
                            <td><i class="btn btn-secondary btn-sm bx bx-plus" data-toggle="collapse" data-target=".row{{ $orders['id'] }}"></i></td>
                            <td>
                                @if(!isset($orders['payment']['payment_status']))
                                <a href="/payment/{{ $orders['id'] }}" class="btn btn-outline-success btn-sm">Pay</a>
                                @endif
                            </td>
                        </tr>
                        <tr class="collapse row{{ $orders['id'] }}">
                            <td colspan="8">
                                <div class="row">
                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <td>Food</td>
                                            <td>Quantity</td>
                                            <td>Price</td>
                                        </tr>
                                        @foreach ($orders['order_details'] as $detail)
                                            <tr>
                                                <td>{{ isset($detail['food']['name']) ? $detail['food']['name'] : '' }}</td>
                                                <td>{{ $detail['quantity'] }}</td>
                                                <td>{{ $detail['total_price'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Total Price</td>
                                            <td class="text-success">{{ $orders['total_price'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("i[data-toggle='collapse']").click(function() {
            var target = $(this).data("target");
            $(target).toggleClass("show");
        });
    });
</script>

@endsection