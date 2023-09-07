@php
    $posted_at = old('posted_at') ?? (isset($post) ? $post->posted_at->format('Y-m-d\TH:i') : null);
@endphp

<div class="form-group">
    <label for="title">
        @lang('posts.attributes.title')
    </label>
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'required']) !!}

    @error('title')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="author_id">
            @lang('posts.attributes.author')
        </label>
        {!! Form::select('author_id', $users, null, ['class' => 'form-control' . ($errors->has('author_id') ? ' is-invalid' : ''), 'required']) !!}

        @error('author_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="posted_at">
            @lang('posts.attributes.posted_at')
        </label>
        <input type="datetime-local" name="posted_at" class="form-control {{ ($errors->has('posted_at') ? ' is-invalid' : '') }}" required value="{{ $posted_at }}">

        @error('posted_at')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="thumbnail_id">
        @lang('posts.attributes.thumbnail')
    </label>
    {!! Form::select('thumbnail_id', $media, null, ['placeholder' => __('posts.placeholder.thumbnail'), 'class' => 'form-control' . ($errors->has('thumbnail_id') ? ' is-invalid' : '')]) !!}

    @error('thumbnail_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>


<div class="form-group">
    <label for="content">
        @lang('posts.attributes.content')
    </label>
    {!! Form::textarea('content', null, ['class' => 'form-control trumbowyg-form' . ($errors->has('content') ? ' is-invalid' : ''), 'required']) !!}

    @error('content')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
