<form
  action="{{ route('home') }}"
  method="GET"
  class="d-flex gap-2"
  data-turbo="true"
  data-turbo-frame="posts"
  data-turbo-action="advance"
>
  <div class="input-group">
    <input
        type="text"
        id="q"
        name="q"
        class="form-control"
        placeholder="@lang('posts.search')"
        value="{{ request('q') }}"
    >
  </div>
</form>
