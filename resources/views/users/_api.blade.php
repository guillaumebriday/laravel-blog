@php
    $data['class'] = 'btn btn-success';

    if ($user->api_token) {
        $data['data-confirm'] = __('forms.tokens.regenerate');
    }
@endphp

<h1>{{ __('users.attributes.api_token') }}</h1>

<div class="form-group">
  {!! Form::label('api_token', __('users.attributes.api_token')) !!}
  {!! Form::text('email', $user->api_token ?? __('users.empty_api_token'), ['class' => 'form-control', 'readonly']) !!}
</div>

<div class="d-flex justify-content-start">
  @if ($user->api_token)
    {!! Form::model($user, ['method' => 'DELETE', 'route' => ['tokens.destroy', $user]]) !!}
      {!! Form::submit(__('forms.actions.delete'), ['class' => 'btn btn-danger', 'data-confirm' => __('forms.tokens.delete')]) !!}
    {!! Form::close() !!}
  @endif

  {!! Form::model($user, ['method' => 'POST', 'route' => ['tokens.store', $user], 'class' => 'ml-auto']) !!}
    {!! Form::submit(__('forms.actions.generate'), $data) !!}
  {!! Form::close() !!}
</div>
