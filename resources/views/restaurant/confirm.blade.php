@extends('layouts.skote.master-layouts')

@section('content')

<div class="main-content">
    <div class="page-section bg-danger border-bottom-white mt-5 pt-5 pb-5">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
            <img src="{{asset('public/images/illustration/student/128/white.svg')}}" width="104" class="mr-md-32pt mb-32pt mb-md-0" alt="student"> 
            <div class="flex mb-32pt mb-md-0">
                <h2 class="text-white mb-0">Order #</h2>
             </div>
        </div>
    </div>
<div class="page-section border-bottom-2 bg-white pt-4">
        <div class="container page__container">
            <div class="row">
                <div class="col-lg-7">
                    <h3 class="mb-3">Order Information</h3>

                    <form class="excludeForm" method="POST" action="{{ route('payment') }}" enctype="multipart/form-data" id="paymentForm">
                    @csrf

                    <input type="hidden" name="orderID" value="{{ $order['id'] }}">
                    <input type="hidden" name="paymentId" value="{{ $order['id'] }}">
                    <input type="hidden" name="PayerID" value="2">
                    <input type="hidden" name="amount" value="{{ $order['total_price'] }}">
                    
                    <div class="mb-3 row">
                        <label for="description" class="col-md-2 col-form-label">Fullname <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            {{ isset(Auth::user()->name) ? Auth::user()->name : ''}}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            {{ isset(Auth::user()->email) ? Auth::user()->email : ''}}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-md-2 col-form-label">Price <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                        </div>
                    </div>
                    <div class="table-responsive bg-white">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <td>Food</td>
                                    <td>Price</td>
                                    <td>Quantity</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr data-base-price="{{ $detail->food->price }}">
                                    <td>{{ isset($detail->food->name) ? $detail->food->name : '' }}</td>
                                    <td class="price">{{ isset($detail->food->price) ? $detail->food->price : '' }}</td>
                                    <td><input type="number" class="form-control quantity" name="quantity[{{ $detail->id }}]" value="{{ $detail->quantity }}" min="1"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h3>Total Price: <span id="total-price" class="text-primary">RM {{ $order['total_price'] }}</span></h3>
                    <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.quantity').on('change', function(){
            var $row = $(this).closest('tr');
            var basePrice = parseFloat($row.data('base-price'));
            var quantity = parseInt($(this).val());
            var totalPrice = basePrice * quantity;
            $row.find('.price').text(totalPrice.toFixed(2));
        });

        function calculateTotalPrice() {
            var totalPrice = 0;
            $('.quantity').each(function(){
                var $row = $(this).closest('tr');
                var basePrice = parseFloat($row.data('base-price'));
                var quantity = parseInt($(this).val());
                totalPrice += basePrice * quantity;
            });
            return totalPrice.toFixed(2);
        }

        $('.quantity').on('change', function(){
            var totalPrice = calculateTotalPrice();
            $('#total-price').text('RM ' + totalPrice);
        });
    });

    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var token = localStorage.getItem('token');
        fetch("{{ route('payment') }}", {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.redirectUrl) {
                redirectToUrlWithToken(data.redirectUrl);
            }
        })
        .catch(error => {
            alert('Error during registration');
        });
    });
</script>
@endsection