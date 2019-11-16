
  <!-- Modal -->
  <div class="modal fade" id="formUser" tabindex="-1" role="dialog" aria-labelledby="formUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <table width="100%">
            <thead>
              <tr>
                <td width="90%"><h3 class="modal-title" id="modalTituloUser"></h3></td>
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
          <form id="userFormModal" action="">
          @csrf
          <input id="UFurl" type="hidden" name="UFurl" value="{{url("user")}}">
          <div class="form-group row">
              <label for="nombres" class="col-md-4 col-form-label text-md-right">{{ __('Nombres') }}</label>

              <div class="col-md-6">
                  <input id="nombres"  type="text" class="form-control" name="nombres"  required autofocus>
              </div>
          </div>

          <div class="form-group row">
              <label for="apellidos" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>

              <div class="col-md-6">
                  <input id="apellidos" type="text" class="form-control" name="apellidos"  required autofocus>
              </div>
          </div>

          <div class="form-group row">
              <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

              <div class="col-md-6">
                  <input id="telefono" type="text" class="form-control" name="telefono" required autofocus>
              </div>
          </div>

          <div class="form-group row">
              <label for="ci" class="col-md-4 col-form-label text-md-right">{{ __('CI') }}</label>

              <div class="col-md-6">
                  <input id="ci" type="text" class="form-control" name="ci"  required autofocus>
              </div>
          </div>

          <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email"  required>
              </div>
          </div>

          <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" required>
              </div>
          </div>

          <div class="form-group row" id="groupPasswordConfirm">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

              <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              </div>
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('userFormModal').reset();">Close</button>
          <button id="btnSubmitFormUser" type="button" class="btn btn-primary" onclick="onSubmitModalFormUser()"></button>
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
              dataType:'json',
              'data':data,
              success:function(docs){
                //docs=JSON.parse(docs);
                if(docs.success){
                  toastr.success(docs.msn,docs.title);
                  $('#formUser').modal('hide');
                }
                else{
                  toastr.error(docs.msn,docs.title);
                }
              }.bind(this)
            });
          };;
    var UFurl;
    var UFdata;
    var UFtoken=$('input[name ="_token"]').val();
    var UFmethod;
    function getAllDataforUserForm(){
      return {
          nombres: $("#nombres").val(),
          apellidos:$("#apellidos").val(),
          telefono: $("#telefono").val(),
          ci:$("#ci").val(),
          email:$("#email").val(),
          password: $("#password").val(),
          password_confirm: $("#password-confirm").val()
      };
    } 
    function LoadDataInForm(id){
        var route=$('#UFurl').val()+'/'+id+"/edit";
        
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
    function openModalFormUser(idUser){
        document.getElementById('userFormModal').reset();
        if(idUser){
        
          $('#modalTituloUser').html("Editar Usuario");
          $('#btnSubmitFormUser').html("Guardar Cambios");
          LoadDataInForm(idUser);
          $('#groupPasswordConfirm').hide(); 
          UFurl=$('#UFurl').val()+'/'+idUser;
          UFmethod='PUT';
        }else{
          $('#modalTituloUser').html("Nuevo Usuario");
          $('#btnSubmitFormUser').html("Registrar");
          $('#groupPasswordConfirm').show();
          UFurl=$('#UFurl').val();
          UFmethod='POST';
        }
    }
    function onSubmitModalFormUser(){
        UFdata=getAllDataforUserForm();
        sendRequestOnSubmit(UFurl,UFdata,UFtoken,UFmethod);
        if(reloadDataTable)
            reloadDataTable();  
    }
  </script>  