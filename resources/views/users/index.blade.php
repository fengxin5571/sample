@extends("layouts.default")
@section("title","所有用户")
@section("content")
<div class="col-md-offset-2 col-md-8">
  <h1>所有用户</h1>
  <ul class="users">
    @foreach ($users as $user)
      <li>
        <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
        <a href="{{ route('users.show', $user->id )}}" class="username">{{ $user->name }}</a>
        <label>性别：{{$user->getSex("$user->sex")}}</label>
        @if(Auth::guard("admin")->check())
        <form action="{{ route('admins.destroy', [Auth::guard('admin')->user(),$user->id]) }}" method="post">
            {{ csrf_field() }}
            
            <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
        </form>
        @endif
      </li>
       
    @endforeach
  </ul>

  {{ $users->links() }}
</div>    
@stop
