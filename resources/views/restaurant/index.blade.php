@extends('layouts.skote.master-layouts')

@section('content')
<style>
    .custom-visible-style {
        visibility: visible !important;
    }
</style>

<div class="main-content">
    <div class="page-section bg-danger border-bottom-white mt-5 pt-5 pb-5">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-md-left mt-5">
            <i class="fa fa-fw fa-building text-white fa-5x"></i>
            <div class="flex mb-32pt mb-md-0">
                <h2 class="text-white mb-0">Restaurant</h2>
             </div>
        </div>
    </div>
    <div class="page-section border-bottom-2 bg-white pt-4">
        <div class="container page__container">
                <div class="row">
                    <div class="col-md-9">
                        <h3 class="mb-3">Restaurant</h3>
                        <div class="row" id="restaurant-list">
        
                            @isset($restaurant)
                            @foreach($restaurant as $restaurants)
                                <div class="col-md-6 col-lg-4 col-xl-4 card-group-row__col d-flex">
                                    <div class="card rounded card-sm card--elevated p-relative o-hidden overlay js-overlay card-group-row__card flex-fill">
    
                                        <div class="card-body flex">
                                            <div class="d-flex">
                                                <div class="flex">
                                                    @if(Auth::check())
                                                        <a class="card-title" href="{{url('/user/restaurant/'.$restaurants['id'])}}">{{ $restaurants['name'] }}</a>
                                                    @else
                                                        <a class="card-title" href="{{ url('/login') }}">{{ $restaurants['name'] }}</a>
                                                    @endif
                                                    <p class="card-text">Category: {{ $restaurants['category']['name'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row justify-content-between">
                                                <div class="col-auto d-flex align-items-center">
                                                    @if(Auth::check())
                                                    <p class="flex text-50 lh-1 mb-0"><small><a href="{{url('/user/restaurant/'.$restaurants['id'])}}" class="btn btn-success waves-effect waves-light float-end">Order</a></small></p>
                                                    @else
                                                    <p class="flex text-50 lh-1 mb-0"><small><a href="{{ url('/login') }}" class="btn btn-success waves-effect waves-light float-end">Login</a></small></p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endisset
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <h4 class="grid-title"><i class="fa fa-filter"></i> Filters</h4>
                                    <hr>
                                
                                    <h5 class="mt-2">Category</h5>
                                    <div class="slider-primary">
                                        <select class="form-control" name="category" id="category-select">
                                            <option disabled selected>Please Select</option>
                                            @foreach($category as $categories)
                                            <option value="{{ $categories['id'] }}" {{ ($request->category == $categories['id']) ? 'selected' : '' }}>{{ $categories['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button id="apply-filter" class="btn btn-outline-success btn-sm float-right mt-3 mr-2">Apply</button>
                                <button id="clear-filter" class="btn btn-outline-warning btn-sm float-right mt-3 mr-1">Clear Filter</button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>


@endsection
@section("script")
<script>
    $(document).ready(function() {
        $('.js-image').each(function() {
            var $img = $(this).find('img');
            var imgUrl = $img.data('img-url');
            $.get(imgUrl, function(data) {
                $img.attr('src', data.url);
            });
        });
        $('.js-image2').each(function() {
            var $img = $(this).find('img');
            var imgUrl = $img.data('img-url2');
            $.get(imgUrl, function(data) {
                $img.attr('src', data.url);
            });
        });
    });

    function updateRestaurantList(restaurants) {
        var restaurantList = $('#restaurant-list');
        restaurantList.empty();
        restaurants.forEach(function(restaurant) {
            var restaurantCard = `
                <div class="col-md-6 col-lg-4 col-xl-4 card-group-row__col d-flex">
                    <div class="card rounded card-sm card--elevated p-relative o-hidden overlay js-overlay card-group-row__card flex-fill">
                        <div class="card-body flex">
                            <div class="d-flex">
                                <div class="flex">
                                    <a class="card-title">${restaurant.name}</a>
                                    <p class="card-text">Category: ${restaurant.category.name}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col-auto d-flex align-items-center">
                                    <p class="flex text-50 lh-1 mb-0">
                                        <small><a href="{{url('/user/restaurant/${restaurant.id}')}}" class="btn btn-success waves-effect waves-light float-end">Order</a></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            restaurantList.append(restaurantCard);
        });
    }

    function fetchRestaurants(categoryId) {
        $.ajax({
            url: "{{ route('restaurant-search') }}",
            method: "POST",
            headers: {
                "Authorization": `Bearer ${localStorage.getItem('token')}`
            },
            data: { category: categoryId },
            success: function(response) {
                updateRestaurantList(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    $('#apply-filter').click(function() {
        var categoryId = $('#category-select').val();
        fetchRestaurants(categoryId);
    });

    $('#clear-filter').click(function() {
        $('#category-select').val('');
        fetchRestaurants('');
    });

</script>
@endsection
