@extends('adminlte::page')

@section('title', 'ព័ត៌មានអតិថិជន')

@section('content_header')
    <div class="row">
        <div class="col-6"><h1>ព័ត៌មានអតិថិជន</h1></div>
        <div class="col-6">
            <button type="button" id="new-customer" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-customer">
                បង្កើតអតិថិជនថ្មី
            </button>
        </div>
    </div>
@stop

@section('content')
    <customer :token="{ value: '{{ csrf_token() }}'}"></customer>
@stop

@section('css')

@stop

@section('js')
    <script>
    </script>
@stop
