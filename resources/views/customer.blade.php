@extends('adminlte::page')

@section('title', 'ព័ត៌មានអតិថិជន')

@section('content_header')
    <div class="row">
        <div class="col-6"><h1>ព័ត៌មានអតិថិជន</h1></div>
        <div class="col-6">
            <button data-v-e1ea323e="" type="button" id="new-customer" class="btn btn-primary float-right add__more" data-toggle="modal" data-target="#modal-customer">
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
