@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>{{ __('dashboard.this_week') }}</h1>
    </div>

    @include('admin/dashboard/_posts')
    @include('admin/dashboard/_comments')
    @include('admin/dashboard/_users')
@endsection
