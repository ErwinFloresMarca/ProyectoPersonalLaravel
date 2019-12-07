
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

          <div class="form-group row">
              <label for="privacidad" class="col-md-4 col-form-label text-md-right">{{ __('Privacidad') }}</label>

              <div class="col-md-6">
                  <input id='privacidad' name="privacidad" data-width="100" type="checkbox" checked data-toggle="toggle" data-on="Publico" data-off="Privado" data-onstyle="success" data-offstyle="danger">    
              </div>
          </div>
          
          <!-- permisos-->
          <div id="groupPermisos">
              <label >{{ __('Permisos:') }}</label>
              <br>
              <div class="form-group row">
                  <label for="ver" class="col-md-4 col-form-label text-md-right">{{ __('Ver') }}</label>
                  <div class="col-md-6">
                      <input id='ver' data-width="100" type="checkbox" checked data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger">    
                  </div>
              </div>
              <div class="form-group row">
                  <label for="editar" class="col-md-4 col-form-label text-md-right">{{ __('Editar') }}</label>
                  <div class="col-md-6">
                      <input id='editar' data-width="100" type="checkbox" checked data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger">    
                  </div>
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
                  reloadDataTable();
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
    var AFprivacidad;
    var AFver;
    var AFeditar;
    function getAllDataforArchivoForm(){
      var fd=new FormData();
      fd.append("user_id","{{Auth::user()->id}}");
      fd.append("archivo",document.getElementById('archivo').files[0]);
      fd.append('privacidad',AFprivacidad);
      fd.append('ver',AFver);
      fd.append('editar',AFeditar);
      return fd;
    } 
    
    function openModalFormArchivo(){
        document.getElementById('FNA').reset();
        $('#MNAtitulo').html("Nuevo Archivo");
        $('#btnSubmitFormArchivo').html("Registrar");
        AFmethod='POST';
        AFprivacidad=AFver=AFeditar=1;    
    }
    function onSubmitModalFormArchivo(){
        AFdata=getAllDataforArchivoForm();
        sendRequestOnSubmit(AFurl,AFdata,AFtoken,AFmethod);
        if(reloadDataTable)
            reloadDataTable();  
    }
    function onPrivacidad(){
      var privacidad=$("#privacidad").val();
      console.log(privacidad);
    }
    $(function() {
      
      $('#privacidad').change(function() {
        if($(this).prop('checked')){
          $('#groupPermisos').show();
          AFprivacidad=1;
        }else{
          $('#groupPermisos').hide();
          AFprivacidad=0;
        }
      });
      $('#ver').change(function() {
        AFver=($(this).prop('checked'))?1:0;
      });
      $('#editar').change(function() {
        AFeditar=($(this).prop('checked'))?1:0;
      });
    });
  </script>  