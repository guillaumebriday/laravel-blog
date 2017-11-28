@extends('users.layout', ['tab' => 'api_token'])

@section('main_content')
  <div class="card">
    <div class="card-body">
      <h1>@lang('users.attributes.api_token')</h1>
      <hr class="my-4">

      <div class="form-group">
        {!! Form::label('api_token', __('users.attributes.api_token')) !!}
        {!! Form::text('api_token', $user->api_token ?? __('users.empty_api_token'), ['class' => 'form-control', 'readonly']) !!}
      </div>

      <div class="d-flex justify-content-start">
        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.token.update', $user], 'class' => 'ml-auto']) !!}
          {!! Form::submit(__('forms.actions.generate'), ['class'=> 'btn btn-success', 'data-confirm' => __('forms.tokens.generate')]) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
