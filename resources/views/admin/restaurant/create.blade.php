@extends('layouts.master')

@section('content')

<div class="d-flex mb-1">
    <div class="flex-shrink-0 me-3">
        <i class="bx bx-store display-4 text-primary mt-1"></i>
    </div>
    <div class="flex-grow-1 my-0">
        <h1 class="mb-0">Restaurant Management</h1>
        <p class="fs-4">Create New Restaurant</p>
    </div>
</div>

<div class="w-100">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('/api/restaurant') }}" enctype="multipart/form-data" class="excludeForm">
                @csrf
                <div class="mb-3 row">
                    <label for="name" class="col-md-2 col-form-label">Restaurant <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" id="name" name="name">
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
                            <option value="{{ $categories['id'] }}">{{ $categories['name'] }}</option>
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
                        <textarea class="form-control" id="description" name="description"></textarea>
                        @error('description')
                            <span class="text-danger mt-3">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="location" class="col-md-2 col-form-label">Location <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="location" name="location"></textarea>
                        @error('location')
                            <span class="text-danger mt-3">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                @hasanyrole('Super Administrator|admin')
                <div class="mb-3 row">
                    <label for="category" class="col-md-2 col-form-label">Manager <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <select class="form-control" name="manager_id" id="manager_id">
                            <option disabled selected>Please Select</option>
                            @foreach($user as $users)
                            <option value="{{ $users['id'] }}">{{ $users['name'] }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="text-danger mt-3">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                @endrole

                <div class="mb-3 row">
                    <label for="featured" class="col-md-2 form-check-label">Enabled?</label>
                    <div class="col-md-10">
                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" checked="">
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
                            <input class="form-check-input" type="checkbox" id="approval" name="approval" checked="">
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

        </div>
    </div>
    <!-- end card -->
</div>



@endsection

@section('script')
<script>
    $('#category, #manager_id').select2();

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
