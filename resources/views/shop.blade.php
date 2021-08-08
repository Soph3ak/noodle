@extends('adminlte::page')

@section('title', 'អំពីហាង')

@section('content_header')
    <div class="row">
        <div class="col-6 pl-5"><h1>អំពីហាង</h1></div>
        {{--<div class="col-6">
            <button type="button" id="new-table" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-shop">
                បង្កើតតុថ្មី
            </button>
        </div>--}}
    </div>
@stop

@section('content')
    <shop :token="{ value: '{{ csrf_token() }}'}"></shop>
@stop

@section('css')

@stop

@section('js')
    <script>
    </script>
@stop
