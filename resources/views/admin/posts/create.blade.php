@extends('admin.layouts.app')

@section('content')
    <h1>@lang('posts.create')</h1>

    {!! Form::open(['route' => ['admin.posts.store'], 'method' =>'POST']) !!}
        @include('admin/posts/_form')

        {{ link_to_route('admin.posts.index', __('forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
        {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
