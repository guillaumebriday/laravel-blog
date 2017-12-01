@extends('admin.layouts.app')

@section('content')
  <div class="page-header">
    <h1>@lang('dashboard.this_week')</h1>
  </div>

  <div class="row">
    <div class="col-xl-4 col-sm-6 mb-3">
      @include('admin/dashboard/_posts')
    </div>

    <div class="col-xl-4 col-sm-6 mb-3">
      @include('admin/dashboard/_comments')
    </div>

    <div class="col-xl-4 col-sm-6 mb-3">
      @include('admin/dashboard/_users')
    </div>
  </div>
@endsection
