@extends('admin.layouts.app')

@section('content')
    <h1>@lang('posts.create')</h1>

    {!! Form::open(['route' => ['admin.posts.store'], 'method' =>'POST']) !!}
        @include('admin/posts/_form')

        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
            @lang('forms.actions.back')
        </a>

        {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
