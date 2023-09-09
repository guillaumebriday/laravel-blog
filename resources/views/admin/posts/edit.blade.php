@extends('admin.layouts.app')

@section('content')
    <p>
        @lang('posts.show') :

        <a href="{{ route('posts.show', $post) }}">
            {{ route('posts.show', $post) }}
        </a>
    </p>

    @include('admin/posts/_thumbnail')

    <form action="{{ route('admin.posts.update', $post) }}" method="POST">
        @method('PUT')
        @csrf

        @include('admin/posts/_form')

        <div class="pull-left">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                @lang('forms.actions.back')
            </a>

            <input type="submit" class="btn btn-primary" value="@lang('forms.actions.update')">
        </div>
    </form>

    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="form-inline pull-right" data-confirm="@lang('forms.posts.delete')">
        @method('DELETE')
        @csrf

        <button type="submit" name="submit" class="btn btn-link text-danger">
            <i class="fa-solid fa-trash" aria-hidden="true"></i>
            @lang('posts.delete')
        </button>
    </form>
@endsection
