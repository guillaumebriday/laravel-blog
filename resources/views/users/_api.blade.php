@php
    $data['class'] = 'btn btn-success';

    if ($user->api_token) {
        $data['data-confirm'] = __('forms.users.regenerate');
    }
@endphp

@component('components.panels.default')
    @slot('title')
        <strong>{{ __('users.attributes.api_token') }}</strong>
    @endslot

      <div class="form-group">
        {!! Form::label('api_token', __('users.attributes.api_token')) !!}
        @if ($user->api_token)
            <div class="well well-sm">{!! $user->api_token !!}</div>
        @else
            @component('components.alerts.default', ['type' => 'warning'])
              {{ __('users.empty_api_token') }}
            @endcomponent
        @endif
      </div>

    {!! Form::model($user, ['method' => 'POST', 'route' => ['users.api_token', $user]]) !!}
      <div class="pull-right">
        {!! Form::submit(__('forms.actions.generate'), $data) !!}
      </div>
    {!! Form::close() !!}
@endcomponent
