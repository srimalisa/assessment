<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Administration</li>
                @if(Auth::check())
                    <li>
                        <a href="{{ url('/') }}" class="waves-effect">
                            <i class="bx bx-laptop"></i>
                            <span key="t-chat">Main Screen</span>
                        </a>
                    </li>
                    @hasanyrole('Super Administrator|admin|Manager')
                        <li>
                            <a href="{{ url('/admin/restaurant') }}" class="waves-effect">
                                <i class="bx bx-restaurant"></i>
                                <span key="t-chat">Restaurant</span>
                            </a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('Manager')
                        <li>
                            <a href="{{ url('/admin/order') }}" class="waves-effect">
                                <i class="bx bx-money"></i>
                                <span key="t-chat">Order</span>
                            </a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('Super Administrator|admin|Manager')
                        <li>
                            <a href="{{ url('/admin/report') }}" class="waves-effect">
                                <i class="bx bx-book"></i>
                                <span key="t-chat">Report</span>
                            </a>
                        </li>
                    @endhasanyrole
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
