<form action="{{ route('admin.users.update', $user) }}" method="POST">
  @method('PATCH')
  @csrf

  <div class="row">
    <div class="form-group mb-3 col-md-6">
      <label class="form-label" for="name">
        @lang('users.attributes.name')
      </label>

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

    <div class="form-group mb-3 col-md-6">
      <label class="form-label" for="email">
        @lang('users.attributes.email')
      </label>

      <input
          type="email"
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

  <div class="row">
    <div class="form-group mb-3 col-md-6">
      <label class="form-label" for="password">
        @lang('users.attributes.password')
      </label>

      <input
          type="password"
          id="password"
          name="password"
          @class(['form-control', 'is-invalid' => $errors->has('password')])
          placeholder="@lang('users.placeholder.password')"
      >

      @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group mb-3 col-md-6">
      <label class="form-label" for="password_confirmation">
        @lang('users.attributes.password_confirmation')
      </label>

      <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')])
          placeholder="@lang('users.placeholder.password_confirmation')"
      >

      @error('password_confirmation')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>
  </div>

  <div class="form-group mb-3">
    <label class="form-label" for="roles">
        @lang('users.attributes.roles')
    </label>

    @foreach($roles as $role)
      <div class="checkbox">
        <label>
          <input type="checkbox" name="roles[{{ $role->id }}]" value="{{ $role->id }}" @checked($user->hasRole($role->name))>

          @if (Lang::has('roles.' . $role->name))
            {!! __('roles.' . $role->name) !!}
          @else
            {{ ucfirst($role->name) }}
          @endif
        </label>
      </div>
    @endforeach
  </div>

  <a href="{{ route('admin.users.index') }}" class="btn btn-light">
      <x-icon name="chevron-left" />

      @lang('forms.actions.back')
  </a>

  <button type="submit" class="btn btn-primary">
      <x-icon name="save" />

      @lang('forms.actions.update')
  </button>
</form>
