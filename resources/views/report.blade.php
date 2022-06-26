@extends('adminlte::page')

@section('title', 'របាយការណ៏លក់')

@section('content_header')

@stop

@section('content')
    <report :token="{ value: '{{ csrf_token() }}'}"></report>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="{{ asset('css/custom-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/gg-icon.css') }}" />
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@stop
