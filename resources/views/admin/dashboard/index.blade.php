@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>@lang('dashboard.this_week')</h1>
    </div>

    <div class="card-deck">
      @include('admin/dashboard/_posts')
      @include('admin/dashboard/_comments')
      @include('admin/dashboard/_users')
    </div>
@endsection
