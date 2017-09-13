@extends('admin.layouts.app')

@section('content')
    <h1>{{ $post->title }} <small>{{ link_to_route('posts.show', __('posts.show'), $post) }}</small></h1>

    @if ($post->hasThumbnail())
        <p>
            {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'img-thumbnail', 'width' => '350']) }}

            {!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts_thumbnail.destroy', $post], 'data-confirm' => __('forms.posts.delete_thumbnail')]) !!}
                {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('posts.delete_thumbnail'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </p>
    @endif

    {!! Form::model($post, ['route' => ['admin.posts.update', $post], 'method' =>'PUT', 'files' => true]) !!}
        @include('admin/posts/_form')

        {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary pull-left']) !!}

    {!! Form::close() !!}

    {!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts.destroy', $post], 'class' => 'form-inline pull-right', 'data-confirm' => __('forms.posts.delete')]) !!}
        {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('posts.delete'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
    {!! Form::close() !!}
@endsection
