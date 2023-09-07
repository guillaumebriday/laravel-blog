@extends('admin.layouts.app')

@section('content')
    <p>
        @lang('posts.show') :

        <a href="{{ route('posts.show', $post) }}">
            {{ route('posts.show', $post) }}
        </a>
    </p>

    @include('admin/posts/_thumbnail')

    {!! Form::model($post, ['route' => ['admin.posts.update', $post], 'method' =>'PUT']) !!}
        @include('admin/posts/_form')

        <div class="pull-left">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                @lang('forms.actions.back')
            </a>

            {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

    {!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts.destroy', $post], 'class' => 'form-inline pull-right', 'data-confirm' => __('forms.posts.delete')]) !!}
        {!! Form::button('<i class="fa-solid fa-trash" aria-hidden="true"></i> ' . __('posts.delete'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
    {!! Form::close() !!}
@endsection
