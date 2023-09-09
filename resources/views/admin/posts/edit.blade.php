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
                <x-icon name="chevron-left" />

                @lang('forms.actions.back')
            </a>

            <button type="submit" class="btn btn-primary">
                <x-icon name="save" />

                @lang('forms.actions.update')
            </button>
        </div>
    </form>

    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="form-inline pull-right" data-confirm="@lang('forms.posts.delete')">
        @method('DELETE')
        @csrf

        <button type="submit" name="submit" class="btn btn-link text-danger">
            <x-icon name="trash" />

            @lang('posts.delete')
        </button>
    </form>
@endsection
