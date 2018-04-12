@extends("layouts.default")
@section("title","更新个人资料")
@section("content")
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>更新管理员个人资料</h5>
    </div>
      <div class="panel-body">

        @include('shared._errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="{{ $admin->gravatar('200') }}" alt="{{ $admin->admin_name }}" class="gravatar"/>
          </a>
        </div>

        <form method="POST" action="{{route('admins.edit',$admin)}}">
          
            {{ csrf_field() }}

            <div class="form-group">
              <label for="name">名称：</label>
              <input type="text" name="admin_name" class="form-control" value="{{ $admin->admin_name }}">
              <p class="text-danger">{{$errors->first('admin_name')}}</p>
            </div>
            
            <div class="form-group">
              <label for="email">邮箱：</label>
              <input type="text" name="admin_email" class="form-control" value="{{ $admin->admin_email }}" disabled>
              <p class="text-danger">{{$errors->first('email')}}</p>
            </div>
            
            <div class="form-group">
              <label for="password">密码：</label>
              <input type="password" name="admin_password" class="form-control" value="{{ old('admin_password') }}">
              <p class="text-danger">{{$errors->first('admin_password')}}</p>
            </div>
            
            <div class="form-group">
              <label for="password_confirmation">确认密码：</label>
              <input type="password" name="admin_password_confirmation" class="form-control" value="{{ old('admin_password_confirmation') }}">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
  </div>
</div>
@stop
