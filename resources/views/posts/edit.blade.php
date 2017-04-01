@extends('layouts.app')

@section('content')
    @component('components.panels.default')
        @slot('title')
            {{ __('posts.edit_article') }}
        @endslot

        @if ($post->hasThumbnail())
            {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'img-responsive']) }}

            {!! Form::model($post, ['method' => 'DELETE', 'route' => ['posts.destroy_thumbnail', $post], 'data-confirm' => __('forms.posts.delete_thumbnail')]) !!}
                {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('posts.delete_thumbnail'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        @endif

        {!! Form::model($post, ['route' => ['posts.update', $post], 'method' => 'patch', 'files' => true]) !!}
            @include ('posts/_form')
        {!! Form::close() !!}
    @endcomponent
@endsection
