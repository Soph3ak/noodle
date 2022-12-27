@extends('adminlte::page')

@section('title', 'POS')

{{--@section('content_header')
    <h1>ទំព័រដើម</h1>
@stop--}}

@section('content')
    <router-view></router-view>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="{{ asset('css/custom-daterangepicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/gg-icon.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@stop

@section('js')
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

    </script>
@stop
