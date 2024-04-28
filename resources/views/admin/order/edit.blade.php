@extends('layouts.master')

@section('content')

<div class="d-flex mb-1">
    <div class="flex-shrink-0 me-3">
        <i class="bx bx-store display-4 text-primary mt-1"></i>
    </div>
    <div class="flex-grow-1 my-0">
        <h1 class="mb-0">Order Management</h1>
        <p class="fs-4">Edit Order</p>
    </div>
</div>

<div class="w-100">
    <div class="card">
        <div class="card-body">
            <div class="tab-pane fade show active" id="detail_tab" role="tabpanel" aria-labelledby="detail-tab">
                <form class="excludeForm" method="POST" action="{{url('/api/admin-order/'.$order['id'])}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered">
                    <tr>
                        <td>Order ID</td>
                        <td># {{ $order['id'] }}</td>
                    </tr>
                    <tr>
                        <td>Restaurant</td>
                        <td>{{ $order['restaurant']['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Buyer</td>
                        <td>{{ $order['user']['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td>
                            <select class="form-control select" name="order_status">
                                <option disabled selected>Please Select</option>
                                @foreach ($status as $statuses)
                                    <option value="{{ $statuses['id'] }}" {{ $order['order_status'] == $statuses['id'] ? 'selected' : '' }}>{{ $statuses['name'] }}</option>
                                @endforeach
                            </select>
                            @error('order_status')
                                <span class="text-danger mt-3">{{$message}}</span>
                            @enderror
                        </td>
                    </tr>
                </table>
                <div class="d-flex flex-wrap mt-3">
                    <div class="ms-auto my-3">
                        <button class="btn btn-primary pull-right">Update Order Status</button>
                    </div>
                </div>
                </form>

                <p class="fs-4 mt-2">List of Food</p>
                <div class="row">
                    @foreach ($order['order_details'] as $orders)
                        <div class="col-md-4 mb-4">
                            <div class="card food-card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $orders['food']['name'] }}</h5>
                                    <p class="card-text">Quantity: {{ $orders['quantity'] }}</p>
                                    <p class="card-text">Price: {{ $orders['total_price'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')
<script>
    $('.select').select2();

    $('.excludeForm').submit(function(event) {
        event.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        var token = localStorage.getItem('token');

        var errorMessages = document.querySelectorAll('.text-danger');
        errorMessages.forEach(function(message) {
            message.textContent = '';
        });

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                var errors = response.errors;
                for (var key in errors) {
                    var errorDiv = document.createElement('span');
                    errorDiv.className = 'text-danger mt-3';
                    errorDiv.innerText = errors[key][0];
                    document.getElementById(key).parentNode.appendChild(errorDiv);
                }
            }
        });
    });
</script>
@endsection
