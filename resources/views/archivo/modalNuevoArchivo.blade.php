
  <!-- Modal -->
  <div class="modal fade" id="MNA" tabindex="-1" role="dialog" aria-labelledby="MNA" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <table width="100%">
            <thead>
              <tr>
                <td width="90%"><h3 class="modal-title" id="MNAtitulo"></h3></td>
                <td width="10%">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </td>
              </tr>
            </thead>
          </table>
        
          
        </div>
        <div class="modal-body">
          <form id="FNA" action="">
          
        

          <div class="form-group row">
              <label for="archivo" class="col-md-4 col-form-label text-md-right">{{ __('Archivo') }}</label>

              <div class="col-md-6">
                  <input id="archivo" type="file" class="form-control" name="archivo"  required autofocus>
              </div>
          </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('FNA').reset();">Close</button>
          <button id="btnSubmitFormArchivo" type="button" class="btn btn-primary" onclick="onSubmitModalFormArchivo()"></button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var sendRequestOnSubmit=(url,data,token,method)=>{
            $.ajax({
              'url': url,
              headers: {'X-CSRF-TOKEN':token},
              type: method,
              //dataType:'json',
              'data':data,
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
    var AFurl="{{url('archivo')}}";
    var AFdata;
    var AFtoken="{{ csrf_token() }}";
    var AFmethod;
    function getAllDataforArchivoForm(){
      var fd=new FormData();
      fd.append("user_id","{{Auth::user()->id}}");
      fd.append("archivo",document.getElementById('archivo').files[0]);
      fd.append("privacidad","1");
      return fd;
    } 
    function LoadDataInForm(id){
        
        var onSucces=function(docs){
            var docs=JSON.parse(docs);
            $("#nombres").val(docs.nombres);
            $("#apellidos").val(docs.apellidos);
            $("#telefono").val(docs.telefono);
            $("#ci").val(docs.ci);
            $("#email").val(docs.email);  
        };
        onSucces.bind(this);
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN':UFtoken},
            type: 'GET',
            dataType:'json',
            success:function(docs){
              onSucces(docs);
            }
        });
    }
    function openModalFormArchivo(idArchivos){
        document.getElementById('FNA').reset();
        if(idArchivos){
        
          $('#MNAtitulo').html("Editar Usuario");
          $('#btnSubmitFormArchivo').html("Guardar Cambios");
          LoadDataInForm(idArchivos);
          AFurl=UFurl+'/'+idArchivos;
          AFmethod='PUT';
        }else{
          $('#MNAtitulo').html("Nuevo Archivo");
          $('#btnSubmitFormArchivo').html("Registrar");
          AFmethod='POST';
        }
    }
    function onSubmitModalFormArchivo(){
        AFdata=getAllDataforArchivoForm();
        console.log(AFdata);
        if(AFdata.archivo){
            var reader = new FileReader();
            reader.readAsText(AFdata.archivo);
            reader.onload = function(e){
                alert(e.target.result);
            };
        } 
        sendRequestOnSubmit(AFurl,AFdata,AFtoken,AFmethod);
        if(reloadDataTable)
            reloadDataTable();  
    }
  </script>  