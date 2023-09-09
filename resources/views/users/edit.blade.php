@extends('users.layout', ['tab' => 'profile'])

@section('main_content')
  <x-card>
    <h1>@lang('users.profile')</h1>
    <hr class="my-4">

    <form action="{{ route('users.update') }}" method="POST">
      @method('PATCH')
      @csrf

      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">
          @lang('users.attributes.name')
        </label>

        <div class="col-sm-5">
          <input
              type="text"
              id="name"
              name="name"
              @class(['form-control', 'is-invalid' => $errors->has('name')])
              placeholder="@lang('users.placeholder.name')"
              required
              value="{{ old('name', $user) }}"
          >

          @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">
          @lang('users.attributes.email')
        </label>

        <div class="col-sm-5">
          <input
              type="text"
              id="email"
              name="email"
              @class(['form-control', 'is-invalid' => $errors->has('email')])
              placeholder="@lang('users.placeholder.email')"
              required
              value="{{ old('email', $user) }}"
          >

          @error('email')
              <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="form-group offset-sm-2">
        <button type="submit" class="btn btn-primary">
            <x-icon name="save" />

            @lang('forms.actions.save')
        </button>
      </div>
    </form>
  </x-card>
@endsection
