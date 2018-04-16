@extends("layouts.default")
@section("title","更新个人资料")
@section("content")
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>更新个人资料</h5>
    </div>
      <div class="panel-body">

        @include('shared._errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" class="gravatar"/>
          </a>
        </div>

        <form method="POST" action="{{ route('users.update', $user->id )}}" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">上传图片：</label>
              <input type="file" name="user_img" class="form-control" value="">
              <p class="text-danger">{{$errors->first('name')}}</p>
              <img src="/storage/images/6.bmp" width="500"/>
            </div>
            <div class="form-group">
              <label for="name">名称：</label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}">
              <p class="text-danger">{{$errors->first('name')}}</p>
            </div>

            <div class="form-group">
              <label for="email">邮箱：</label>
              <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
              <p class="text-danger">{{$errors->first('email')}}</p>
            </div>
            <div class="form-group">
              <label for="password">性别：</label>
              <div class=""radio"">
                @foreach($user->getSex() as $key=>$value)
            	<label><input type="radio" name="sex" value="{{$key}}"  @if($user->sex==$key)checked="checked"@endif >{{$value}}</label>
            	@endforeach
          	  </div>
            </div>
            <div class="form-group">
              <label for="password">密码：</label>
              <input type="password" name="password" class="form-control" value="{{ old('password') }}">
              <p class="text-danger">{{$errors->first('password')}}</p>
            </div>
            
            <div class="form-group">
              <label for="password_confirmation">确认密码：</label>
              <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
  </div>
</div>
@stop
