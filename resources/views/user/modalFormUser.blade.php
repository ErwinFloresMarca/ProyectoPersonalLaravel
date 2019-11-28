
  <!-- Modal -->
  <div class="modal fade" id="formUser" tabindex="-1" role="dialog" aria-labelledby="formUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <table width="100%">
            <thead>
              <tr>
                <td width="90%"><h4 class="modal-title" id="modalTituloUser"></h4></td>
                <td width="10%">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </td>
              </tr>
            </thead>
          </table>
        
          
        </div>
        <div class="modal-body" >
        <div class="box box-primary" style="margin:0%;">
        <div class="box-body">
          <form id="userFormModal" action="" class="form-horizontal">
          @csrf
          <input id="UFurl" type="hidden" name="UFurl" value="{{url("user")}}">
          <div id="group_nombres" class="form-group col-sm-6">
              <label for="nombres" class="control-label">{{ __('Nombres') }}</label>
              <input id="nombres"  type="text" class= "form-control" name="nombres"  required autofocus>
              <span id="span_nombres" class="help-block" > </span>
          </div>
          <div class="col-sm-1"></div>

          <div id="group_apellidos" class="form-group col-sm-6">
              <label for="apellidos" class="control-label">{{ __('Apellidos')}}</label>
              <input id="apellidos" type="text" class="form-control" name="apellidos"  required autofocus>
              <span id="span_apellidos" class="help-block" > </span>
          </div>

          <div id="group_telefono" class="form-group col-sm-6">
            <label for="telefono" class="control-label">{{ __('Telefono') }}</label>
              <input id="telefono" type="text" class="form-control" name="telefono"  required autofocus>
              <span id="span_telefono" class="help-block" > </span>
          </div>
          <div class="col-sm-1"></div>
          <div id="group_ci" class="form-group col-sm-6">
            <label for="ci" class="control-label">{{ __('Ci') }}</label>
              <input id="ci" type="text" class="form-control" name="ci"  required autofocus>
              <span id="span_ci" class="help-block" > </span>
          </div>

          <div id="group_email" class="form-group col-sm-12">
            <label for="email" class="control-label">{{ __('Email') }}</label>
              <input id="email" type="email" class="form-control" name="email"  required autofocus>
              <span id="span_email" class="help-block" > </span>
          </div>
          
          <div id="group_password" class="form-group col-sm-6">
            <label for="password" class="control-label">{{ __('Password') }}</label>
              <input id="password" type="password" class="form-control" name="password"  required autofocus>
              <span id="span_password" class="help-block" > </span>
          </div>
          <div class="col-sm-1"></div>
          <div id="group_password_confirm" class="form-group col-sm-6">
            <label for="password_confirm" class="control-label">{{ __('Confirm password') }}</label>
              <input id="password_confirm" type="password" class="form-control" name="password_confirm"  required autofocus>
              <span id="span_password_confirm" class="help-block" > </span>
          </div>
          </form>
        </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('userFormModal').reset();">Cancel</button>
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
                  defaultModal();
                }
                else{
                  toastr.error(docs.msn,docs.title);
                }
              }.bind(this),
              error:function(err){
                verificarError(err.responseJSON.errors);
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
          password_confirm: $("#password_confirm").val()
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
        defaultModal();
        if(idUser){
          $('#modalTituloUser').html("Editar Usuario");
          $('#btnSubmitFormUser').html("Guardar Cambios");
          LoadDataInForm(idUser);
          $('#group_password_confirm').hide(); 
          UFurl=$('#UFurl').val()+'/'+idUser;
          UFmethod='PUT';
        }else{
          $('#modalTituloUser').html("Nuevo Usuario");
          $('#btnSubmitFormUser').html("Registrar");
          $('#group_password_confirm').show();
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
    function verificarError(err){
      var keys=['nombres','apellidos','telefono','ci','email','password','password_confirm'];
      console.log(err);
      keys.forEach(element => {
        CambiarValid(element,err[element]);
      });
    }
    function CambiarValid(input,status){
      $('#group_'+input).removeClass('has-success');
      $('#group_'+input).removeClass('has-error');
      
      if(input!='password_confirm')
        if(status){
          $('#group_'+input).addClass('has-error');
          $('#span_'+input).html('<i class="fa fa-times-circle-o"></i> '+status[0]);
          $('#span_'+input).show();
        }
        else {
          if(input!='password'){
          $('#group_'+input).addClass('has-success');
          $('#span_'+input).html('<i class="fa fa-check"></i> '+' Se ve bien!!!');
          $('#span_'+input).show();}
        }
      else{
        $('#group_'+input).val('');
        $('#group_password').val('');
      }
        
    }
    function defaultModal(){
      document.getElementById('userFormModal').reset();
      $('#formUser').modal('hide');
      //reset conf group  monbres
      $('#group_nombres').removeClass('has-success');
      $('#group_nombres').removeClass('has-error');
      $('#span_nombres').text('');
      $('#span_nombres').hide();
      //reset conf group  apellidos
      $('#group_apellidos').removeClass('has-success');
      $('#group_apellidos').removeClass('has-error');
      $('#span_apellidos').text('');
      $('#span_apellidos').hide();
      //reset conf group  telefono
      $('#group_telefono').removeClass('has-success');
      $('#group_telefono').removeClass('has-error');
      $('#span_telefono').text('');
      $('#span_telefono').hide();
      //reset conf group  ci
      $('#group_ci').removeClass('has-success');
      $('#group_ci').removeClass('has-error');
      $('#span_ci').text('');
      $('#span_ci').hide();
      //reset conf group  email
      $('#group_email').removeClass('has-success');
      $('#group_email').removeClass('has-error');
      $('#span_email').text('');
      $('#span_email').hide();
      //reset conf group  password
      $('#group_password').removeClass('has-success');
      $('#group_password').removeClass('has-error');
      $('#span_password').text('');
      $('#span_password').hide();
      //reset conf group  _passwordConfirm
      $('#group_password_confirm').removeClass('has-success');
      $('#group_password_confirm').removeClass('has-error');
      $('#span_password_confirm').text('');
      $('#span_password_confirm').hide();
    }
  </script>  