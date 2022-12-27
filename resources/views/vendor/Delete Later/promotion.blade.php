@extends('adminlte::page')

@section('title', 'ព័ត៌មានតុ')

@section('content_header')
    <div class="row">
        <div class="col-6"><h1>ប្រូម៉ូសិន</h1></div>
        <div class="col-6">
            <button type="button" id="new-table" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-seatTable">
                បង្កើតប្រូម៉ូសិនថ្មី
            </button>
        </div>
    </div>
@stop

@section('content')
    <promotion :token="{ value: '{{ csrf_token() }}'}"></promotion>
@stop

@section('css')

@stop

@section('js')
    <script>
    </script>
@stop
