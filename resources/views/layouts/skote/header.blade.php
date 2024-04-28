<style>
    .topnav1-header {
        margin-top: 0;
    }

    .container-fluid-header {
        padding-top: 0;
    }
</style>
<div class="topnav topnav1-header bg-light">
    <div class="container-fluid container-fluid-header bg-light">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <a class="navbar-brand" href="{{ url('/') }}">Restaurant</a>
            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target=".collapse">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/user/restaurant') }}" class="nav-link text-dark">Restaurant</a>
                    </li>
                    @if(Auth::check())
                    <li class="nav-item">
                        <a href="{{ url('/user/allorder') }}" class="nav-link text-dark">List of Order</a>
                    </li>
                    @endif

                </ul>
                
                <ul class="navbar-nav">
                    @if(Auth::check())
                        @hasanyrole('Super Administrator|admin|Manager')
                        <li class="nav-item">
                            <a href="{{ url('/admin/restaurant') }}" class="nav-link text-dark">Administrator Panel</a>
                        </li>
                        @endhasanyrole

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                                <span key="t-dashboards" class="text-dark border border-success rounded p-2">{{ Auth::user()->name }}</span>
                                <div class="arrow-down text-dark d-lg-none"></div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <form id="logoutForm" action="{{ route('logout.api') }}" method="POST">
                                        @csrf
                                        <button type="button" onclick="logout()" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        @if(Auth::check())
                            {{ Auth::user()->name }}
                        @else
                            <a href="{{ url('/login') }}" class="btn btn-outline-secondary">Login</a>
                        @endif
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>