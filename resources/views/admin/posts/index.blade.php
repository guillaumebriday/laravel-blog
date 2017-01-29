@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>{{ __('dashboard.posts') }}</h1>
    </div>

    @include ('admin/posts/_list')
@endsection
