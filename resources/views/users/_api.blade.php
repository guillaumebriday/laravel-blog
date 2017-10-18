@php
    $data['class'] = 'btn btn-success';

    if ($user->api_token) {
        $data['data-confirm'] = __('forms.tokens.regenerate');
    }
@endphp

<h1>@lang('users.attributes.api_token')</h1>

<div class="form-group">
  {!! Form::label('api_token', __('users.attributes.api_token')) !!}
  {!! Form::text('api_token', $user->api_token ?? __('users.empty_api_token'), ['class' => 'form-control', 'readonly']) !!}
</div>

<div class="d-flex justify-content-start">
  {!! Form::model($user, ['method' => 'POST', 'route' => ['tokens.store', $user], 'class' => 'ml-auto']) !!}
    {!! Form::submit(__('forms.actions.generate'), $data) !!}
  {!! Form::close() !!}
</div>
