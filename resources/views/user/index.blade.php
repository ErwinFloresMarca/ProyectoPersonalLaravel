@extends('layouts.appTemp')



@section('contenido')
    @include('user.modalFormUser')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formUser" onclick="openModalFormUser()">
        Nuevo
    </button>
    <br>
    
    <table id='tablaUsuarios' class="table">
            <thead>
            <tr>
              <th>No.ID</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>CI</th>
              <th>Email</th>
              <th>Telefono</th>
              <th>Opciones</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
    </table>
@endsection
@section('titulo')
    Usuarios
@endsection

@section('js')
<script type="text/javascript">
    toastr.options = {"closeButton":false,"debug":false,"newestOnTop":false,"progressBar":false,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1000","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"," positionClass ":" toast-top-right "};
                
       var tablaUsuarios = $('#tablaUsuarios').DataTable({
            "lengthMenu":[5,10,15,20],
            "ajax":"{{route('user.listUsers')}}",
            columns:[
                {data: 'id'},
                {data: 'nombres'},
                {data: 'apellidos'},
                {data: 'ci'},
                {data: 'email'},
                {data: 'telefono'},
                {
                    "render": function(data,type,row){
                        
                        var html='<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#formUser"  onclick="openModalFormUser('+row.id+')"><i class="fa fa-fw fa-edit"></i></button> ';
                        //por completar
                        html=html+'<button type="button" class="btn btn-xs btn-danger"  onclick="onBtnDeletUser('+row.id+')"><i class="fa fa-fw fa-close"></i></button>';
                        return html;
                    }
                }

            ]
        });
    function onBtnDeletUser(id){
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
        tablaUsuarios.ajax.reload();
    }
</script>    
@endsection