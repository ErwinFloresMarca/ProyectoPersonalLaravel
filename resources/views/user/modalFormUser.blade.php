
  <!-- Modal -->
  <div class="modal fade" id="formUser" tabindex="-1" role="dialog" aria-labelledby="formUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTituloUser"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="userFormModal" action="">
          @csrf

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

          <div class="form-group row">
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
    function openModalFormUser(idUser){
        console.log(idUser);
        if(idUser){
            $('#modalTituloUser').append("Editar Usuario");
            $('#btnSubmitFormUser').append("Guardar Cambios");

        }else{
            $('#modalTituloUser').append("Nuevo Usuario");
            $('#btnSubmitFormUser').append("Registrar");
        }
    }
    function onSubmitModalFormUser(){
        console.log("click on submit");
        if(reloadDataTable)
            reloadDataTable();  
    }
  </script>  