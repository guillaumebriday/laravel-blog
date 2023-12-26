<form action="{{ route('admin.comments.update', $comment) }}" method="POST">
    @method('PUT')
    @csrf

    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label class="form-label" for="author_id">
                @lang('comments.attributes.author')
            </label>

            <select name="author_id" id="author_id" @class(['form-control', 'is-invalid' => $errors->has('author_id')]) required>
                @foreach ($users as $id => $name)
                    <option value="{{ $id }}" @selected(old('author_id', $comment) == $id)>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            @error('author_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6">
            <label class="form-label" for="posted_at">
                @lang('comments.attributes.posted_at')
            </label>

            <input
                type="datetime-local"
                id="posted_at"
                name="posted_at"
                @class(['form-control', 'is-invalid' => $errors->has('posted_at')])
                required
                value="{{ old('posted_at') ?? $comment->posted_at->format('Y-m-d\TH:i') }}"
            >

            @error('posted_at')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="content">
            @lang('comments.attributes.content')
        </label>

        <textarea
            name="content"
            id="content"
            cols="50"
            rows="10"
            required
            @class(['form-control', 'is-invalid' => $errors->has('content')])
        >{{ old('content', $comment) }}</textarea>

        @error('content')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="pull-left">
        <a href="{{ route('admin.comments.index') }}" class="btn btn-light">
            <x-icon name="chevron-left" />

            @lang('forms.actions.back')
        </a>

        <button type="submit" class="btn btn-primary">
            <x-icon name="save" />

            @lang('forms.actions.update')
        </button>
    </div>
</form>
