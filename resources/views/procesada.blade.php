@extends('adminlte::page', ['iFrameEnabled' => false])

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Imágenes IA Recientes</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @include('components.compoment_card', ['data' => $data])
        </div>
    </div>
@stop
