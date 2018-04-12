@extends("layouts.default")
@section("title","管理员-$admin->admin_name")
@section("content")
<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div class="col-md-12">
      <div class="col-md-offset-2 col-md-8">
        <section class="user_info">
          @include('shared._admin_info', ['admin' => $admin])
        </section>
      </div>
    </div>
  </div>
</div>
@stop