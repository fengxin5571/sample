<a href="{{ route('admins.show', $admin->id) }}">
  <img src="{{ $admin->gravatar('140') }}" alt="{{ $admin->admin_name }}" class="gravatar"/>
</a>
<h1>{{ $admin->admin_name }}</h1>

