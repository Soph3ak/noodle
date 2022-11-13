@extends('adminlte::page')

@section('title', 'ទំព័រដើម')

@section('content_header')
    <h1>ទំព័រដើម</h1>
@stop

@section('content')
    <dashboard :token="{ value: '{{ csrf_token() }}'}"></dashboard>
@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop
