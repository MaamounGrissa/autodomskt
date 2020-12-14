@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">@yield('title-section')</div>
                <div class="card-body">
                    @yield('content-section')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

