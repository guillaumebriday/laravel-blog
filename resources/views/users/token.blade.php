@extends('users.layout', ['tab' => 'api_token'])

@section('main_content')
  <x-card>
    <h1>@lang('users.attributes.api_token')</h1>
    <hr class="my-4">

    <div class="form-group">
      <label for="api_token">
          @lang('users.attributes.api_token')
      </label>

      <input
          type="text"
          id="api_token"
          name="api_token"
          class="form-control"
          readonly
          value="{{ $user->api_token ?? __('users.empty_api_token') }}"
      >
    </div>

    <div class="d-flex justify-content-start">
      <form action="{{ route('users.token.update', $user) }}" method="POST" class="ml-auto">
        @method('PATCH')
        @csrf

        <button type="submit" class="btn btn-primary" data-confirm="@lang('forms.tokens.generate')">
            <x-icon name="arrows-rotate" />

            @lang('forms.actions.generate')
        </button>
      </form>
    </div>
  </x-card>
@endsection
