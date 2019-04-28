{!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user]]) !!}

  <div class="form-row">
    <div class="form-group col-md-6">
      {!! Form::label('name', __('users.attributes.name')) !!}
      {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required']) !!}

      @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group col-md-6">
      {!! Form::label('email', __('users.attributes.email')) !!}
      {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), 'required']) !!}

      @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      {!! Form::label('password', __('users.attributes.password')) !!}
      {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password')]) !!}

      @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group col-md-6">
      {!! Form::label('password_confirmation', __('users.attributes.password_confirmation')) !!}
      {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation')]) !!}

      @error('password_confirmation')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('roles', __('users.attributes.roles')) !!}

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

  {{ link_to_route('admin.users.index', __('forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
