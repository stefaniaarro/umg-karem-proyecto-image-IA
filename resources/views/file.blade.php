@extends('adminlte::page', ['iFrameEnabled' => false])

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">IA Reconocimiento de Imagen</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <strong>{{ session('success') }}</strong>
                    @endif
                    @if (session('error'))
                        <strong>{{ session('error') }}</strong>
                    @endif
                    <form id="myDrop" class="dropzone" action="{{ route('upload.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script type="text/javascript">
        console.log('IA Reconocimiento de Imagen!');
        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: true,
            uploadMultiple: false,
            addRemoveLinks: true,
            thumbnailWidth: 200,
            thumbnailHeight: 200,

            maxFilesize: 5,
            maxFiles: 10,
            acceptedFiles: "image/*",

            dictCancelUpload: "Cancelar subida",
            dictCancelUploadConfirmation: "¿Seguro que desea cancelar la subida?",
            dictRemoveFile: "Eliminar archivo"
        });
        // DropzoneJS Demo Code End
    </script>
@stop
