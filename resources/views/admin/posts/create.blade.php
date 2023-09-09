@extends('admin.layouts.app')

@section('content')
    <h1>@lang('posts.create')</h1>

    <form action="{{ route('admin.posts.store') }}" method="POST">
        @csrf

        @include('admin/posts/_form')

        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
            @lang('forms.actions.back')
        </a>

        <input type="submit" class="btn btn-primary" value="@lang('forms.actions.save')">
    </form>
@endsection
