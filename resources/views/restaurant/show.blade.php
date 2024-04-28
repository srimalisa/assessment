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
            <i></i>
            <div class="flex mb-32pt mb-md-0">
                <h2 class="text-white mb-0">{{$restaurant['name']}}</h2>
                <p class="text-white">Restaurant</p>
             </div>
        </div>
    </div>
    <div class="page-section border-bottom-2 bg-white pt-4">
        <div class="container page__container">
            <div class="row">

                <div class="col-lg-5">
                    <h3 class="my-3">Description</h3>
                    <p>{{$restaurant['description']}}</p>

                    <h3 class="my-3">Category</h3>
                    <p>{{$restaurant['category']['name']}}</p>

                </div>

                <div class="col-lg-7">
                    <h3 class="mb-3">List of Food</h3>

                    <div class="mb-3 row">
                        <label for="description" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            {{ isset(Auth::user()->name) ? Auth::user()->name : ''}}
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="description" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            {{ isset(Auth::user()->email) ? Auth::user()->email : ''}}
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <form method="POST" class="excludeForm" action="{{ url('/api/user-order') }}" enctype="multipart/form-data" id="orderForm">
                            <div class="row">
                                <div class="mb-3 row">
                                    <label for="type" class="col-md-2 col-form-label">Type <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                    <select class="form-control" name="delivery_type">
                                        @foreach ($delivery as $deliveries)
                                            <option value="{{ $deliveries['id'] }}">{{ $deliveries['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <span class="text-danger mt-3">{{$message}}</span>
                                    @enderror
                                    </div>
                                </div>        
                                @foreach ($food as $foods)
                                    <div class="col-md-4 mb-4">
                                        <div class="card food-card" onclick="toggleFoodSelection(this, {{ $foods['id'] }})">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $foods['name'] }}</h5>
                                                <p class="card-text">{{ $foods['description'] }}</p>
                                                <p class="card-text">Price: {{ $foods['price'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @csrf
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant['id'] }}">
                            <input type="hidden" name="selected_foods" id="selectedFoods">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Order Now</button>
                                @if(!Auth::check())
                                <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    let selectedFoods = [];

    function toggleFoodSelection(card, foodId) {
        card.classList.toggle('selected');

        const index = selectedFoods.indexOf(foodId);
        if (index === -1) {
            selectedFoods.push(foodId);
        } else {
            selectedFoods.splice(index, 1);
        }

        document.getElementById('selectedFoods').value = selectedFoods.join(',');
    }

    document.getElementById('orderForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var token = localStorage.getItem('token');
        fetch("{{ url('/api/user-order') }}", {
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