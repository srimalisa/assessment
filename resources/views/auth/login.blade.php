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
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7 align-self-center">
                                        <div class="text-primary p-4">
                                            <h4 class="text-white">Login</h4>
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
                                    <form id="loginForm" class="excludeForm form-horizontal" method="POST" action="{{ url('/api/login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email</label>
                                            <input name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', '') }}" id="email"
                                                placeholder="Enter Email" autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div
                                                class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                <input type="password" name="password"
                                                    class="form-control  @error('password') is-invalid @enderror"
                                                    id="password" value="" placeholder="Enter password"
                                                    aria-label="Password" aria-describedby="password-addon">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                Remember me
                                            </label>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log
                                                In</button>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-5">
                                                <hr class="mt-2">
                                            </div>
                                            <div class="col-md-2 text-center">OR</div>
                                            <div class="col-md-5">
                                                <hr class="mt-2">
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            New User? <a href="{{ url('/register') }}" class="fw-medium text-danger">Click here to register</a>.<br/>
                                            @if (Route::has('password.request'))
                                                Forgot Password? Click <a href="{{ route('password.request') }}" class="fw-medium text-danger"><i
                                                        class="mdi mdi-lock me-1"></i>Click to reset</a>
                                            @endif
                                        </div>


                                        <div class="mt-4 text-center">
                                            

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
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password,
            }),
        })
        .then(response => response.json())
        .then(data => {
            let adminRoles = ['Super Administrator', 'admin', 'Manager'];
            let prefix = data.role.some(r => adminRoles.includes(r)) ? 'admin' : 'user';
            localStorage.setItem('roles', data.role);
            localStorage.setItem('token', data.token);
            redirectToUrlWithToken(`/${prefix}/restaurant`);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
</script>
@endsection