@extends('layout')

@section('content')
    <div class="container">
        @section('navbar')
            @include('navbar', ['active' => null])
        @show
        <div class="content row">
            @section('left_sidebar')
                @include('left_sidebar')
            @show
            <div class="col-lg-7">
                @section('body')
                    @yield('body')
                @show
            </div>
            @section('right_sidebar')
                @include('right_sidebar')
            @show
        </div>
    </div>
@stop