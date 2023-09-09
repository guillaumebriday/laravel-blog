@extends('admin.layouts.app')

@section('content')
    <div class="page-header d-flex justify-content-between">
      <h1>@lang('dashboard.media')</h1>

      <a href="{{ route('admin.media.create') }}" class="btn btn-primary btn-sm align-self-center">
        <x-icon name="plus-square" prefix="fa-regular" />

        @lang('forms.actions.add')
      </a>
    </div>

    @include('admin/media/_list')
@endsection
