@section('navegation')
<header>

    <!-- Navbar -->
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand waves-light">
                <a href="javascript:void(0)"><i class="fas fa-tools mr-2"></i>{{ config('app.name', 'Laravel') }}</a>
                <div id="close-sidebar">
                    <i class="fas fa-lg fa-arrow-circle-left "></i>
                </div>
            </div>
            <div class="sidebar-header">
                <a href="#">
                    <div class="user-pic">
                        <img id="user-nav-img" class="img-responsive img-circle"
                            src="{{ asset('img/dashboard/sidebar/user.jpg') }}" alt="user"
                            onerror="this.src='{{ asset('img/dashboard/sidebar/user.jpg') }}'">
                    </div>
                </a>
                <div class="user-info">
                    <a href="#">
                        <span class="user-name"><strong>Test User</strong>
                        </span></a>
                    <span class="user-role">Admin</span>
                    <span class="user-status">
                        <i class="fas fa-circle stutus-on"></i>
                        <span>Online</span>
                    </span>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Menu</span>
                    </li>
                    <li class="hoverable waves-light {{ \Request::is('store') ? 'default' : 'simple' }}">
                        <a href="{{ route('index') }}">
                            <i class="fas fa-home"></i>
                            <span>Página principal</span>
                        </a>
                    </li>

                    <li
                        class="hoverable waves-light {{ \Request::is('order') || \Request::is('order/*') ? 'default' : 'simple' }}">
                        <a href="{{route('order.index')}}">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Ordenes</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
        <!-- sidebar-content  -->
        <div class="sidebar-footer">


        </div>
    </nav>

</header>
@endsection
