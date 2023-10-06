@extends('users.layout', ['tab' => 'security'])

@section('main_content')
  <x-card>
    <h1>@lang('users.security')</h1>
    <hr class="my-4">

    <form action="{{ route('users.password.update', $user) }}" method="POST">
      @method('PATCH')
      @csrf

      <div class="form-group mb-3 row">
        <label for="current_password" class="form-label col-sm-4 col-form-label">
            @lang('users.attributes.current_password')
        </label>

        <div class="col-sm-8">
          <input
              type="password"
              id="current_password"
              name="current_password"
              @class(['form-control', 'is-invalid' => $errors->has('current_password')])
              placeholder="@lang('users.placeholder.current_password')"
              required
          >

          @error('current_password')
              <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="form-group mb-3 row">
        <label for="password" class="form-label col-sm-4 col-form-label">
            @lang('users.attributes.password')
        </label>

        <div class="col-sm-8">
          <input
              type="password"
              id="password"
              name="password"
              @class(['form-control', 'is-invalid' => $errors->has('password')])
              placeholder="@lang('users.placeholder.password')"
              required
          >

          @error('password')
              <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="form-group mb-3 row">
        <label for="password_confirmation" class="form-label col-sm-4 col-form-label">
            @lang('users.attributes.password_confirmation')
        </label>

        <div class="col-sm-8">
          <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')])
              placeholder="@lang('users.placeholder.password_confirmation')"
              required
          >

          @error('password_confirmation')
              <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="form-group mb-3 offset-sm-4">
        <button type="submit" class="btn btn-primary">
          <x-icon name="save" />

          @lang('forms.actions.save')
        </button>
      </div>
    </form>
  </x-card>
@endsection
