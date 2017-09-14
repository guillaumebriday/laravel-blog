{!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user]]) !!}

  <div class="form-row">
    <div class="form-group col-md-6">
      {!! Form::label('name', __('users.attributes.name')) !!}
      {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required']) !!}

      @if ($errors->has('name'))
        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
      @endif
    </div>

    <div class="form-group col-md-6">
      {!! Form::label('email', __('users.attributes.email')) !!}
      {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), 'required']) !!}

      @if ($errors->has('email'))
        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
      @endif
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      {!! Form::label('password', __('users.attributes.password')) !!}
      {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password')]) !!}

      @if ($errors->has('password'))
        <span class="invalid-feedback">{{ $errors->first('password') }}</span>
      @endif
    </div>

    <div class="form-group col-md-6">
      {!! Form::label('password_confirmation', __('users.attributes.password_confirmation')) !!}
      {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation')]) !!}

      @if ($errors->has('password_confirmation'))
        <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
      @endif
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

  {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
