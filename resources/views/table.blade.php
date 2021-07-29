@extends('adminlte::page')

@section('title', 'ព័ត៌មានតុ')

@section('content_header')
    <div class="row">
        <div class="col-6"><h1>ព័ត៌មានតុ</h1></div>
        <div class="col-6">
            <button type="button" id="new-table" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-seatTable">
                បង្កើតតុថ្មី
            </button>
        </div>
    </div>
@stop

@section('content')
    <seat-table :token="{ value: '{{ csrf_token() }}'}"></seat-table>
@stop

@section('css')

@stop

@section('js')
    <script>
    </script>
@stop
