@extends('admin.layouts.app')

@section('content')
    <h1>@lang('media.create')</h1>

    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label class="form-label" for="image">
                @lang('media.attributes.image')
            </label>

            <input
                type="file"
                name="image"
                id="image"
                accept="image/*"
                @class(['form-control', 'is-invalid' => $errors->has('image')])
                required
            >

            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="name">
                @lang('media.attributes.name')
            </label>

            <input
                type="text"
                id="name"
                name="name"
                @class(['form-control', 'is-invalid' => $errors->has('name')])
                value="{{ old('name') }}"
            >

            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>


        <a href="{{ route('admin.media.index') }}" class="btn btn-light">
            <x-icon name="chevron-left" />

            @lang('forms.actions.back')
        </a>

        <button type="submit" class="btn btn-primary">
            <x-icon name="save" />

            @lang('forms.actions.save')
        </button>
    </form>
@endsection
