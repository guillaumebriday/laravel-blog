{!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user]]) !!}

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">
        @lang('users.attributes.name')
      </label>
      {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required']) !!}

      @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="email">
        @lang('users.attributes.email')
      </label>
      {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), 'required']) !!}

      @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="password">
        @lang('users.attributes.password')
      </label>
      {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password')]) !!}

      @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="password_confirmation">
        @lang('users.attributes.password_confirmation')
      </label>
      {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation')]) !!}

      @error('password_confirmation')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>
  </div>

  <div class="form-group">
    <label for="roles">
        @lang('users.attributes.roles')
    </label>

    @foreach($roles as $role)
      <div class="checkbox">
        <label>
          {!! Form::checkbox("roles[$role->id]", $role->id, $user->hasRole($role->name)) !!}
          @if (Lang::has('roles.' . $role->name))
            {!! __('roles.' . $role->name) !!}
          @else
            {{ ucfirst($role->name) }}
          @endif
        </label>
      </div>
    @endforeach
  </div>

  <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
      @lang('forms.actions.back')
  </a>

  {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
