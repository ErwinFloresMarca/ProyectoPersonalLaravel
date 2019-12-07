@extends('layouts.appTemp')

@section('contenido')

<div class="row">
    <div class="col-sm-7" >
    
    @if($tipoEditor!='office')
    <div class="notranslate">
        <h3 class="text-center">{{$archivo->nombre}}</h3>
    <textarea  rows='13' class="form-control" id="editor" name="editor" readonly>
{{$contenido}}
    </textarea>
    </div>
    @if ($archivo->privacidad==1)
    @if ($archivo->permisos->editar==1)
        <div class="text-center">
        <button id='btnEdit' class="btn btn-danger" onclick="cambiarEditable(Editable)">Editar</button>
        <button id='btnGuardar' class="btn btn-primary" onclick="guardarCambios()">Guardar</button>    
        </div>
    @endif
            
    @endif
    

    @else
    <h3 class="text-center">{{$archivo->nombre}}</h3>
<iframe width='100%' height="400px" align='top' style='border: none;' src="https://docs.google.com/viewerng/viewer?url={{url('').$archivo->ruta}}&amp;embedded=true"></iframe>
    
    @endif
    </div>
    <div class="col-sm-5">
        <div class="text-center" >
            @if ($archivo->qr)
            <img  width="200px" src="{{url('').$archivo->qr->ruta}}" >    
            @endif    
            <br><br>
            <a href="{{url('').$archivo->ruta}}" download="{{$archivo->nombre}}">
                <button class="btn btn-success btn-xl">Descargar</button>
            </a>
            <br>
            <br>
            @if ($tipoEditor=='office'&&$archivo->privacidad==1)
            @if ($archivo->permisos->editar==1)
                <div class="alert alert-warning">
                    Este tipo de archivo no puede editarse directamente <br>
                    Puede editarlo de forma indirecta y subir el archivo editado si prefiere.
                </div>
                <input type="file" id="archivoActualizado">
                <button class="btn btn-primary" onclick="guardarCambios()">Guardar</button>
            
            @endif
            @endif
        </div>
    </div>
</div>

@endsection

@section('titulo')
    Editar Archivo
@endsection

@section('js')
<script>
    toastr.options = {"closeButton":false,"debug":false,"newestOnTop":false,"progressBar":false,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1000","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"," positionClass ":" toast-top-right "};        
@if($archivo->permisos)
@if($archivo->permisos->editar==1)
    function enviarCambios(addData){
            $.ajax({
              url: '{{url('archivo/guardarCambios').'/'.$archivo->id}}',
              headers: {'X-CSRF-TOKEN':"{{ csrf_token() }}"},
              type: 'POST',
              'data':getDataForSend(addData),
              processData: false,
              contentType: false,
              cache:false,
              success:function(docs){
                //docs=JSON.parse(docs);
                if(docs.success){
                  toastr.success(docs.msn,docs.title);
                  $('#MNA').modal('hide');
                }
                else{
                  toastr.error(docs.msn,docs.title);
                }
              }.bind(this)
            });
          };;
    function getDataForSend(addData){
      var fd=new FormData();
      addData(fd);
      
      fd.append('tipoEditor','{{$tipoEditor}}');
      return fd;
    } 
    //guardar cambios
    @if($tipoEditor!='office')

    var EDIT_CONTENT=$('#editor').val();
    function guardarTexto(){
        @if($tipoEditor=='codemirror')
            Editor.save();
        @endif
        let contenido=$('#editor').val();
        if(contenido==EDIT_CONTENT){
            toastr.warning("No Existe ningun cambio en el texto","No se guardo");
        }else{
            enviarCambios((fd)=>{
                fd.append('contenido',contenido);
            });
            EDIT_CONTENT=$('#editor').val();
        }  
    }
    @else
    function guardarArchivo(){
        let file=document.getElementById('archivoActualizado').files[0];
        if(file){
            let pos=file.name.indexOf('(');
            let nombreArchivo=file.name;
            if(pos>0)
                nombreArchivo=(file.name.split('.')[0].substring(0,pos)).replace(/\s*$/,"")+'.'+file.name.split('.')[1];
            if(nombreArchivo=='{{$archivo->nombre}}'){
                enviarCambios((fd)=>{
                    fd.append('archivo',file);
                });
            }
            else
                toastr.warning("El archivo no coinside","Error al cargar el archivo");
        }else{
            toastr.warning("Elija un archivo con el mismo nombre","Error al cargar el archivo");
        }
        
    }
    @endif
    function guardarCambios(){
    @auth
        @if($tipoEditor=='office')
            guardarArchivo();
        @else
            guardarTexto();
        @endif
    @else
        toastr.warning("Usted no puede guardar ningun cambio porque no inicio seccion!!!","Opcion no Disponible");
        return;

    @endauth
    }
@endif
@endif
    //fin guardar cambios
    
    @if($tipoEditor=='codemirror')
        var Editable=false;
        var Editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "{{$cmConfMode}}",
            readOnly: true
        });
        function cambiarEditable(edit){
            @auth
            if(edit){
                Editor.options.readOnly=true;
                Editable=false;
                $("#btnEdit").removeClass('btn-success');
                $("#btnEdit").addClass('btn-danger');
            }else{
                Editor.options.readOnly=false;
                Editable=true;
                $("#btnEdit").removeClass('btn-danger');
                $("#btnEdit").addClass('btn-success');
            }
            @else
                toastr.warning("Usted no puede editar archivos porque no inicio seccion!!!","Opcion no Disponible");
                return;
            @endauth
            
        }
    @else
        @if($tipoEditor=='office')

        @else
            var Editable=false;
            function cambiarEditable(edit){
                if(edit){
                    $("#editor").attr('readOnly',true);
                    Editor.options.readOnly=true;
                    Editable=false;
                    $("#btnEdit").removeClass('btn-success');
                    $("#btnEdit").addClass('btn-danger');
                }else{
                    $("#editor").attr('readOnly',false);
                    Editable=true;
                    $("#btnEdit").removeClass('btn-danger');
                    $("#btnEdit").addClass('btn-success');
                }
            }
        @endif
    @endif
</script>    
@endsection


