<a href="{{ route('users.show', $user->id) }}">
  <img src="{{ $user->gravatar('140') }}" alt="{{ $user->name }}" class="gravatar"/>
</a>
<h1>{{ $user->name }}</h1>
<div class="form-group">
<label for="password">性别：</label>
{{$user->getSex("$user->sex")}}
</div>
