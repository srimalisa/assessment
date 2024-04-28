@extends('layouts.master')

@section('content')

<div class="d-flex mb-1">
    <div class="flex-shrink-0 me-3">
        <i class="bx bx-store display-4 text-primary mt-1"></i>
    </div>
    <div class="flex-grow-1 my-0">
        <h1 class="mb-0">Restaurant Management</h1>
        <p class="fs-4">Edit Restaurant</p>
    </div>
</div>

<div class="w-100">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail_tab" type="button" role="tab" aria-controls="detail_tab" aria-selected="true">Restaurant Management</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="food-tab" data-bs-toggle="tab" data-bs-target="#food_tab" type="button" role="tab" aria-controls="food_tab" aria-selected="false">Food</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="detail_tab" role="tabpanel" aria-labelledby="detail-tab">
                    <form class="excludeForm" method="POST" action="{{url('/api/restaurant/'.$restaurant['id'])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
        
                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Restaurant <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="name" name="name" value="{{ $restaurant['name'] }}">
                                @error('name')
                                    <span class="text-danger mt-3">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <label for="category" class="col-md-2 col-form-label">Category <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select class="form-control" name="category" id="category">
                                    <option disabled selected>Please Select</option>
                                    @foreach($category as $categories)
                                    <option value="{{ $categories['id'] }}" {{ $categories['id'] == $restaurant['category_id'] ? 'selected' : '' }}>{{ $categories['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="text-danger mt-3">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label">Description <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="description" name="description">{{ $restaurant['description'] }}</textarea>
                                @error('description')
                                    <span class="text-danger mt-3">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <label for="location" class="col-md-2 col-form-label">Location <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="location" name="location">{{ $restaurant['location'] }}</textarea>
                                @error('location')
                                    <span class="text-danger mt-3">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <label for="featured" class="col-md-2 form-check-label">Enabled?</label>
                            <div class="col-md-10">
                                <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" {{ $restaurant['status'] == 1 ? 'checked' : '' }}>
                                </div>
                                @error('featured')
                                    <span class="text-danger mt-3">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        @hasanyrole('Super Administrator|admin')
                        <div class="mb-3 row">
                            <label for="approval" class="col-md-2 form-check-label">Approval?</label>
                            <div class="col-md-10">
                                <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="approval" name="approval" {{ $restaurant['approval'] == 3 ? 'checked' : '' }}>
                                </div>
                                @error('approval')
                                    <span class="text-danger mt-3">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @endrole
        
                        <div class="row">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade show" id="food_tab" role="tabpanel" aria-labelledby="food-tab">
                    <form method="POST" action="{{url('/api/food/'.$restaurant['id'])}}" enctype="multipart/form-data" class="excludeForm">
                    @csrf
                    @method('PUT')
                        <table class="table table-bordered table-striped" id="food_table">
                            <tr class="text-center">
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Action</td>
                            </tr>
                            @foreach ($food as $foods)
                            <input type="hidden" name="food_id[{{ $foods['id'] }}]" value="{{ $foods['id'] }}">
                                <tr>
                                    <td>
                                        <input type="text" id="f_name[{{$foods['id']}}]" name="f_name[{{$foods['id']}}]" class="form-control" value="{{$foods['name']}}"/>
                                        @error('f_name['.$foods['id'].']')
                                            <span class="text-danger mt-3">{{$message}}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" id="f_description[{{$foods['id']}}]" name="f_description[{{$foods['id']}}]" class="form-control" value="{{$foods['description']}}"/>
                                        @error('f_description['.$foods['id'].']')
                                            <span class="text-danger mt-3">{{$message}}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" id="f_price[{{$foods['id']}}]" name="f_price[{{$foods['id']}}]" class="form-control" value="{{$foods['price']}}"/>
                                        @error('f_price['.$foods['id'].']')
                                            <span class="text-danger mt-3">{{$message}}</span>
                                        @enderror
                                    </td>
                                    <td><button data-remote="{{url('/api/food/'.$foods['id'])}}" class="btn btn-sm btn-danger btn-delete delete">Delete</button></td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                    <a class="btn btn-success float-right" href="javascript:;" data-toggle="modal" id="new">Add Food</a>
                    <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Add Food</h4>
                                </div>
                                <form class="excludeForm" method="POST" action="{{ url('/api/food') }}" enctype="multipart/form-data">
                                @csrf
                                <input class="form-control" type="hidden" id="restaurant_id" name="restaurant_id" value="{{ $restaurant['id'] }}">
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Name <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" id="food_name" name="food_name">
                                            @error('food_description')
                                                <span class="text-danger mt-3">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Description <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" id="food_description" name="food_description">
                                            @error('food_description')
                                                <span class="text-danger mt-3">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Price <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" id="price" name="price">
                                            @error('price')
                                                <span class="text-danger mt-3">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary pull-right">Save</button>
                                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')
<script>
    $('#category').select2();
    $('#new').click(function () {
        $('#crud-modal').modal('show');
    });

    $('#food_table').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                var token = localStorage.getItem('token');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                dataType: 'json',
                data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    location.reload();
                });
            }
        })
    });

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
