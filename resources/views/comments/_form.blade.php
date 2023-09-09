@auth
  <form id="comments_form" action="{{ route('comments.store') }}" method="POST" data-turbo="true">
    @csrf

    <input type="hidden" name="post_id" value="{{ $post->id }}">

    <div class="form-group">
      <textarea
          name="content"
          id="content"
          cols="50"
          rows="10"
          @class(['form-control', 'is-invalid' => $errors->has('content')])
          placeholder="@lang('comments.placeholder.content')"
          required
      >{{ old('content', $comment ?? null) }}</textarea>

      @error('content')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group text-right">
      <input type="submit" class="btn btn-primary" value="@lang('comments.comment')">
    </div>
  </form>
@else
  <x-alert type="warning">
    @lang('comments.sign_in_to_comment')
  </x-alert>
@endauth
