@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>
        {{ __('dashboard.posts') }}
        <small>{{ link_to_route('admin.posts.create', __('forms.actions.add'), [], ['class' => 'btn btn-primary btn-sm']) }}</small>
      </h1>
    </div>

    @include ('admin/posts/_list')
@endsection
