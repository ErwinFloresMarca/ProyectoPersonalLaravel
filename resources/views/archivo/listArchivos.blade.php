@include('layouts.hoverComponent')
<table id='tablaArchivos' class="table" >
        <thead>
        <tr>
          <th>Nombre</th>
          <th>Fecha de Creacion</th>
          <th>Fecha de Ultima Modificación</th>
          @if(Request::path()=='archivo')
          <th>Privacidad</th>
          <th>Propiedades</th>
          @endif
        </tr>
        </thead>
        <tbody>

        </tbody>
</table>
<script>
    toastr.options = {"closeButton":false,"debug":false,"newestOnTop":false,"progressBar":false,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1000","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"," positionClass ":" toast-top-right "};        
    var urlDataTable="{{url('archivo').'/'.((Auth::check())?Auth::id():0).'/listArchivos/'.((Request::path()=='archivo')?1:0)}}";
    var tablaArchivos = $('#tablaArchivos').DataTable({
        "lengthMenu":[5,10,15,20],
        "ajax":urlDataTable,
        columns:[
            {data: 'nombre',
                render:function(data,type,row){
                    let html='<a class="objeto" href="{{url("archivo")."/"}}'+row.id+'">'+data;
                    if(row.qr)
                        html+='<div class="objetoOculto" width="400px" heigth="400px"><img  width="100px" src="{{url("")}}'+row.qr.ruta+'"></img></div>';
                    html+='</a>';
                    return html;
                }
            },
            {data: 'creado_hace'},
            {data: 'actualizado_hace'},
            @if(Request::path()=='archivo')
            {data: 'privacidad',
                render: function(data,type,row){
                    let html="<button onclick='onClickBtnPrivacidad("+row.id+","+row.privacidad+")'";  
                    if(row.privacidad==1)
                        html+=" class='btn btn-success btn-xs'>"+"Publico"+"</button>";
                    else
                        html+=" class='btn btn-danger btn-xs'>"+"Privado"+"</button>";
                    return html;
                }
            },
            {
                "render": function(data,type,row){
                    var html="";
                    if(row.permisos){
                    html=html+'<div class="btn-group">'
                    html=html+'<button type="button" class="btn btn-warning dropdown-toggle btn-xs" data-toggle="dropdown">'
                        html=html+'Permisos<span class="caret"></span>'
                        html=html+'<span class="sr-only">Toggle Dropdown</span>'
                    html=html+'</button>'
                    html=html+'<ul class="dropdown-menu" role="menu">'
                        html=html+'<li><div class="pretty p-default p-toggle">'
                        html=html+'<input onclick="onClickPermisosVer('+row.permisos.id+','+row.permisos.ver+')" name="tooglePermisosVer" value="'+row.permisos.id+'" type="checkbox" '+((parseInt(''+row.permisos.ver))?'checked':'')+'/>'
                        html=html+'<div class="state p-success p-on"><label>Visible</label></div>'
                        html=html+'<div class="state p-danger p-off"><label>No Visible</label></div>'
                        html=html+'</div></li>'
                        
                        html=html+'<li><div class="pretty p-default p-toggle">'
                        html=html+'<input onclick="onClickPermisosEditar('+row.permisos.id+','+row.permisos.editar+')" name="tooglePermisosEditar" value="'+row.permisos.id+'" type="checkbox" '+((parseInt(''+row.permisos.editar))?'checked':'')+'/>'
                        html=html+'<div class="state p-success p-on"><label>Editable</label></div>'
                        html=html+'<div class="state p-danger p-off"><label>No Editable</label></div>'
                        html=html+'</div></li>'
                    html=html+'</ul>'
                    html=html+'</div>'
                    }
                    html=html+'<button type="button" class="btn btn-xs btn-danger"  onclick="onBtnDeletArchivo('+row.id+')"><i class="fa fa-fw fa-close"></i></button>';
                    return html;
                }
            }
            @endif
            

        ]
    });
function reloadDataTable(){
    tablaArchivos.ajax.reload();
}
@if(Request::path()=='archivo')
//seccion modificadores
function onBtnDeletArchivo(id){
    $.ajax({
        url: '{{url("archivo")}}'+'/'+id,
        headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
        type: 'DELETE',
        dataType:'json',
        success:function(docs){
            toastr.success(docs.msn,docs.title);
        }
    });
    reloadDataTable();
}

function onClickBtnPrivacidad(id,privacidad){
    if(id){
        $.ajax({
            url: '{{url("archivo")}}'+'/'+id,
            headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            type: 'PUT',
            dataType:'json',
            data:{
                changes:['privacidad'],
                privacidad: (1-privacidad)
            },
            success:function(docs){
                toastr.success(docs.msn,docs.title);
            }
        });
        reloadDataTable();
    }
}
//fin seccion modificadores
@endif
</script>