@extends('layouts.skote.master-layouts')

@section('title')
    Login
@endsection

@section('content')
<div class="bg-image " 
     style="background-image: url({{url('images/banner/envato1.jpg')}});
            height: 100%">
        <div class="mdk-box__content d-flex align-items-center justify-content-center container page__container py-112pt"
                style="min-height: 656px;">
            <!-- <div class="card card--transparent mb-0"> -->
            <div class="row justify-content-center mt-5">
                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h4 class="text-white ml-4">Account Registration</h4>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-2">
                                    <form method="POST" class="excludeForm form-horizontal" action="{{ url('/api/register') }}" enctype="multipart/form-data" id="studentForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail"
                                            value="{{ old('email') }}" name="email" placeholder="Enter email" autofocus required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Fullname</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" id="username" name="name" autofocus required
                                                placeholder="Enter your fullname">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" name="password"
                                                placeholder="Enter password" autofocus required>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="confirmpassword" name="password_confirmation"
                                            name="password_confirmation" placeholder="Enter Confirm password" autofocus required>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mt-4 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light"
                                                type="submit">Register</button>
                                        </div>

                                        <div class="mt-3 d-grid">
                                        <p>Already have an account ? <a href="{{ url('login') }}" class="fw-medium text-danger">
                                        Click here to login</a>.</p>
                                        </div>

                                    
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            <!-- </div> -->
        </div>

</div>


@endsection
@section('script')
<script>
    document.getElementById('studentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        fetch("{{ url('/api/register') }}", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                let adminRoles = ['Super Administrator', 'admin', 'Manager'];
                let prefix = data.role.some(r => adminRoles.includes(r)) ? 'admin' : 'user';
                localStorage.setItem('roles', data.role);
                localStorage.setItem('token', data.token);
                redirectToUrlWithToken(`/${prefix}/restaurant`);
            } else {
                alert('Registration failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            alert('Error during registration');
        });
    });
    </script>
@endsection