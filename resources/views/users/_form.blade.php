{!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user]]) !!}

  <div class="form-group">
    {!! Form::label('name', trans('users.attributes.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('users.placeholder.name')]) !!}
  </div>

  <div class="form-group">
    {!! Form::label('email', trans('users.attributes.email')) !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('users.placeholder.email')]) !!}
  </div>

  <div class="form-group">
    {!! Form::label('password', trans('users.attributes.password')) !!}
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('users.placeholder.password')]) !!}
  </div>

  <div class="form-group">
    {!! Form::label('password_confirmation', trans('users.attributes.password_confirmation')) !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('users.placeholder.password_confirmation')]) !!}
  </div>

  <div class="pull-right">
    <a href="{{ route('users.show', $user) }}" class="btn btn-default">{{ trans('forms.actions.back') }}</a>
    {!! Form::submit(trans('forms.actions.save'), ['class' => 'btn btn-success']) !!}
  </div>

{!! Form::close() !!}
