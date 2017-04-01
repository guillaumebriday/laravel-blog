@extends('layouts.app')

@section('content')
    @component('components.panels.default')
        @slot('title')
            {{ __('posts.edit_article') }}
        @endslot

        @if ($post->hasThumbnail())
            {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'img-responsive']) }}
        @endif

        {!! Form::model($post, ['route' => ['posts.update', $post], 'method' => 'patch', 'files' => true]) !!}
            @include ('posts/_form')
        {!! Form::close() !!}
    @endcomponent
@endsection
