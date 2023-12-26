@auth
  <form id="comments_form" action="{{ route('comments.store') }}" method="POST" data-turbo="true">
    @csrf

    <input type="hidden" name="post_id" value="{{ $post->id }}">

    <div class="form-group mb-3">
      <textarea
          name="content"
          id="content"
          cols="50"
          rows="3"
          @class(['form-control', 'is-invalid' => $errors->has('content')])
          placeholder="@lang('comments.placeholder.content')"
          required
      >{{ old('content', $comment ?? null) }}</textarea>

      @error('content')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group mb-3 text-end">
      <button type="submit" class="btn btn-primary">
          <x-icon name="paper-plane" />

          @lang('comments.comment')
      </button>
    </div>
  </form>
@else
  <x-alert type="warning">
    @lang('comments.sign_in_to_comment')
  </x-alert>
@endauth
