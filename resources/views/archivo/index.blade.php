@extends('layouts.appTemp')

@section('contenido')
    @auth
    @include('archivo.modalNuevoArchivo')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MNA" onclick="openModalFormArchivo()">
        Subir Archivo
    </button>
    @endauth
    
    @include('archivo.listArchivos')
    @include('permisos.methodsPermisos')
@endsection
@section('titulo')
    Archivos
@endsection

@section('js')
<script type="text/javascript">
    
</script>    
@endsection