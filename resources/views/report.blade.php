@extends('adminlte::page')

@section('title', 'របាយការណ៏លក់')

@section('content_header')
    <div class="row">
        <div class="col-6"><h1>របាយការណ៏លក់</h1></div>
        {{--<div class="col-4 text-center">
            <div id="reportrange1" style="background: #fff; cursor: pointer; border: 1px solid #ccc; width: 50%" class="form-control">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>--}}
        <div class="col-6">
            <button type="button" id="report" class="btn btn-primary float-right">
                របាយការណ៏លក់
            </button>
        </div>
    </div>
@stop

@section('content')
    <report :token="{ value: '{{ csrf_token() }}'}"></report>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="{{ asset('css/custom-daterangepicker.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@stop
