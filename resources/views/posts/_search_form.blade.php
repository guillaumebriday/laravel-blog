<form action="{{ route('home') }}" method="GET" class="d-flex" data-turbo="true" data-turbo-frame="posts" data-turbo-action="advance">
  @csrf

  <div class="input-group mr-sm-3">
    <input
        type="text"
        id="q"
        name="q"
        class="form-control"
        placeholder="@lang('posts.search')"
        value="{{ request('q') }}"
    >
  </div>

  <button type="submit" class="btn btn-primary">
    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
  </button>
</form>
