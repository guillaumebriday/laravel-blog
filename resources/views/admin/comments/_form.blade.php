{!! Form::model($comment, ['route' => ['admin.comments.update', $comment], 'method' =>'PUT' ]) !!}

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="author_id">
                @lang('comments.attributes.author')
            </label>
            {!! Form::select('author_id', $users, null, ['class' => 'form-control' . ($errors->has('author_id') ? ' is-invalid' : ''), 'required']) !!}

            @error('author_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="posted_at">
                @lang('comments.attributes.posted_at')
            </label>
            <input type="datetime-local" name="posted_at" class="form-control {{ ($errors->has('posted_at') ? ' is-invalid' : '') }}" required value="{{ old('posted_at') ?? $comment->posted_at->format('Y-m-d\TH:i') }}">

            @error('posted_at')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="content">
            @lang('comments.attributes.content')
        </label>
        {!! Form::textarea('content', null, ['class' => 'form-control' . ($errors->has('content') ? ' is-invalid' : ''), 'required']) !!}

        @error('content')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="pull-left">
        <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
            @lang('forms.actions.back')
        </a>

        {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}

{!! Form::model($comment, ['method' => 'DELETE', 'route' => ['admin.comments.destroy', $comment], 'class' => 'form-inline pull-right', 'data-confirm' => __('forms.comments.delete')]) !!}
    {!! Form::button('<i class="fa-solid fa-trash" aria-hidden="true"></i> ' . __('comments.delete'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
{!! Form::close() !!}
