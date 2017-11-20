{!! Form::open() !!}
  <div class="form-group row">
      {!! Form::label('name', __('users.attributes.name'), ['class' => 'col-sm-2 col-form-label']) !!}

      <div class="col-sm-5">
          {!! Form::text('name', $user->name, ['class' => 'form-control', 'readonly']) !!}
      </div>
  </div>

  <div class="form-group row">
      {!! Form::label('email', __('users.attributes.email'), ['class' => 'col-sm-2 col-form-label']) !!}

      <div class="col-sm-5">
          {!! Form::text('email', $user->email, ['class' => 'form-control', 'readonly']) !!}
      </div>
  </div>

  <div class="form-group row">
      {!! Form::label('nb_of_posts', __('users.nb_of_posts'), ['class' => 'col-sm-2 col-form-label']) !!}

      <div class="col-sm-5">
          {!! Form::text('nb_of_posts', $user->posts()->count(), ['class' => 'form-control', 'readonly']) !!}
      </div>
  </div>

  <div class="form-group row ">
      {!! Form::label('nb_of_comments', __('users.nb_of_comments'), ['class' => 'col-sm-2 col-form-label']) !!}

      <div class="col-sm-5">
          {!! Form::text('nb_of_comments', $user->comments()->count(), ['class' => 'form-control', 'readonly']) !!}
      </div>
  </div>

  <div class="form-group row">
    {!! Form::label('roles', __('users.attributes.roles'), ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-5">
      @forelse($roles as $role)
        <div class="form-check disabled">
          <label class="form-check-label">
              {!! Form::checkbox(null, $role->name, $user->hasRole($role->name), ['class' => 'form-check-input', 'disabled']) !!}
              @if (Lang::has('roles.' . $role->name))
                {!! __('roles.' . $role->name) !!}
              @else
                {{ ucfirst($role->name) }}
              @endif
          </label>
        </div>
      @empty
        @lang('roles.none')
      @endforelse
    </div>
  </div>
{!! Form::close() !!}
