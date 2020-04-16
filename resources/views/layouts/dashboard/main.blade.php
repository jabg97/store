@extends('layouts.app')
@section('main')
@include('layouts.dashboard.nav')
<div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
    <a id="show-sidebar" class="btn btn-dark bg-color-gradient-primary" href="javascript:void(0)">
        <i class="fas  fa-2x fa-bars"></i>
    </a>
    @yield('navegation')
    <main class="page-content">
        @yield('content')
    </main>
</div>
@endsection
