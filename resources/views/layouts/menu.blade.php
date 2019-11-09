<!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          @auth
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{asset("bootstrapTemplates/dist/img/avatar5.png")}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{explode(" ",(Auth::user()->nombres))[0]}} {{explode(" ",(Auth::user()->apellidos))[0]}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>    
          @endauth
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            
            <li>
              <a href="{{route("user.index")}}">
                <i class="fa fa-th"></i> <span>Usuario</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
