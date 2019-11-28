<header class="main-header" >

    <!-- Logo -->
    <a href="{{url('')}}" class="logo" style="background-color: #009900;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>L</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Proyecto</b>Laravel</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color: #009900;">

      <!-- Sidebar toggle button-->
      @auth
        <a href="#" class="sidebar-toggle " data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>    
      @endauth
      
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        @if (Route::has('login'))

            @auth
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                    <img src="{{asset("bootstrapTemplates/dist/img/avatar5.png")}}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{explode(" ",Auth::user()->nombres)[0]}} {{explode(" ",Auth::user()->apellidos)[0]}}</span>
                    </a>
                    <ul class="dropdown-menu" >
                    <!-- User image -->
                    <li class="user-header" style="background-color: #009900;">
                        <img src="{{asset("bootstrapTemplates/dist/img/avatar5.png")}}" class="img-circle" alt="User Image">

                        <p>
                        {{Auth::user()->nombres}} {{Auth::user()->apellidos}}
                        <small>Member since {{Auth::user()->created_at}}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                        <a href="{{route('home')}}" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                Sign out
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    </ul>
                </li>
            @else
            @if (Request::path()!="login")
            <li>
                <a href="{{ route('login') }}">Login</a>
            </li>
            @endif

                @if (Route::has('register')&&(Request::path()!="register"))
                <li>
                    <a href="{{ route('register') }}">Register</a>
                </li>
                @endif
            @endauth

        @endif


        </ul>
      </div>

    </nav>
  </header>
