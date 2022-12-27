@extends('adminlte::page')

@section('title', 'ព័ត៌មានអតិថិជន')
@section('page-header', 'ព័ត៌មានអតិថិជន')

@section('content_header')
    <div class="d-flex justify-content-between">
        <div class=""><h1>ព័ត៌មានអតិថិជន</h1></div>
        <div class="ml-auto">
            <button data-v-e1ea323e="" type="button" id="new-customer" class="btn btn-primary add__more" data-toggle="modal" data-target="#modal-customer">
                <span data-v-e1ea323e="" class="d-flex justify-content-center align-items-center">
                    <i data-v-e1ea323e="" class="gg-add mr-2"></i>
                    បង្កើតអតិថិជនថ្មី
                </span>
            </button>
        </div>
    </div>
@stop

@section('content')
    <customer :token="{ value: '{{ csrf_token() }}'}"></customer>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/gg-icon.css') }}" />
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){

            $('.card-body').overlayScrollbars({ overflowBehavior : {
                    x : "hidden",
                    y : "scroll"
                }, });
        });
    </script>
@stop
