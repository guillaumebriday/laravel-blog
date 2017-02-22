@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>{{ __('dashboard.comments') }}</h1>
    </div>

    @include ('admin/comments/_list')
@endsection
