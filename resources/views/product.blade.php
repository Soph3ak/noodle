@extends('adminlte::page')

@section('title', 'ព័ត៌មានមុខម្ហូប')

@section('content_header')
    <div class="row">
        <div class="col-6"><h1>ព័ត៌មានមុខម្ហូប</h1></div>
        <div class="col-6">
            <button type="button" id="new-product" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-product">
                បង្កើតមុខម្ហូបថ្មី
            </button>
        </div>
    </div>
@stop

@section('content')
    <product :token="{ value: '{{ csrf_token() }}'}" ref="vueModal"></product>
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function(){


        });
    </script>
@stop
