@extends('layouts.appTemp')

@section('contenido')
    @include('archivo.modalNuevoArchivo')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MNA" onclick="openModalFormArchivo()">
        Subir Archivo
    </button>
    <table id='tablaArchivos' class="table">
            <thead>
            <tr>
              <th>No.ID</th>
              <th>Nombre</th>
              <th>Privacidad</th>
              <th>Propiedades</th>
              
            </tr>
            </thead>
            <tbody>

            </tbody>
    </table>
@endsection
@section('titulo')
    Archivos
@endsection

@section('js')
<script type="text/javascript">
    toastr.options = {"closeButton":false,"debug":false,"newestOnTop":false,"progressBar":false,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1000","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"," positionClass ":" toast-top-right "};
                
       var tablaArchivos = $('#tablaArchivos').DataTable({
            "lengthMenu":[5,10,15,20],
            "ajax":"{{route('archivo.listArchivos')}}",
            columns:[
                {data: 'id'},
                {data: 'nombre'},
                {data: 'privacidad'},
                {
                    "render": function(data,type,row){
                        
                        var html='<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#formUser"  onclick="openModalFormArchivo('+row.id+')"><i class="fa fa-fw fa-edit"></i></button> ';
                        
                        html=html+'<button type="button" class="btn btn-xs btn-danger"  onclick="onBtnDeletArchivo('+row.id+')"><i class="fa fa-fw fa-close"></i></button>';
                        return html;
                    }
                }

            ]
        });
    function onBtnDeletArchivo(id){
        $.ajax({
            url: '{{url("user")}}'+'/'+id,
            headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            type: 'DELETE',
            dataType:'json',
            success:function(docs){
                toastr.success(docs.msn,docs.title);
            }
        });
        reloadDataTable();
    }
    function reloadDataTable(){
        tablaArchivos.ajax.reload();
    }
    
</script>    
@endsection