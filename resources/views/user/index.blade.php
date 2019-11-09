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
        $('#tablaUsuarios').DataTable({
            "lengthMenu":[5,10,15,20],
            "ajax":"{{route('user.listUsers')}}",
            columns:[
                {data: 'id'},
                {data: 'nombres'},
                {data: 'apellidos'},
                {data: 'email'},
                {data: 'telefono'},
                {data: 'ci'},
                {
                    "render": function(data,type,row){
                        
                        var html='<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#formUser"  onclick="openModalFormUser('+row.id+')"><i class="fa fa-fw fa-edit"></i></button> ';
                        //por completar
                        html=html+'<button type="button" class="btn btn-danger"  onclick="onBtnDeletoUser('+row.id+')"></button>';
                        return html;
                    }
                }

            ]
        });
    function onBtnDeletoUser(id){
        reloadDataTable();
    }
    function reloadDataTable(){
        
    }
</script>    
@endsection