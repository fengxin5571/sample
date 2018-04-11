<header class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="col-md-offset-1 col-md-10">
      <a href="{{route('home')}}" id="logo">Sample App</a>
      <nav>
        <ul class="nav navbar-nav navbar-right">
          @if(Auth::guard('admin')->check())
          <li><a href="#">用户列表</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{ Auth::guard('admin')->user()->admin_name }} <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href="{{Auth::guard('admin')->user()->id}}">个人中心</a></li>
                <li><a href="{{route('users.edit')}}">编辑资料</a></li>
                <li class="divider"></li>
                <li>
                  <a id="logout" href="#">
                    <form action="{{route('admin_logout')}}" method="POST">
                      {{ csrf_field() }}
                      
                      <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                    </form>
                  </a>
                </li>
              </ul>
            </li>
          @else
          @if(Auth::check())
          <li><a href="#">用户列表</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{ Auth::user()->name }} <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('users.show', Auth::user()->id) }}">个人中心</a></li>
                <li><a href="{{route('users.edit',Auth::user())}}">编辑资料</a></li>
                <li class="divider"></li>
                <li>
                  <a id="logout" href="#">
                    <form action="{{ route('logout') }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                    </form>
                  </a>
                </li>
              </ul>
            </li>
          @else
          <li><a href="{{route('help')}}">帮助</a></li>
          <li><a href="{{route('login')}}">登录</a></li>
          <li><a href="{{route('admin_login')}}">管理员登录</a></li>
          @endif
          @endif
        </ul>
      </nav>
    </div>
  </div>
</header>