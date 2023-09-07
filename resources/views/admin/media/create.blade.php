@extends('admin.layouts.app')

@section('content')
    <h1>@lang('media.create')</h1>

    {!! Form::open(['route' => ['admin.media.store'], 'method' =>'POST', 'files' => true]) !!}
        <div class="form-group">
            <label for="image">
                @lang('media.attributes.image')
            </label>
            {!! Form::file('image', ['accept' => 'image/*', 'class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'required']) !!}

            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">
                @lang('media.attributes.name')
            </label>
            {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')]) !!}

            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>


        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
            @lang('forms.actions.back')
        </a>

        {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
