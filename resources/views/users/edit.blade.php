@extends('layouts.app')

@section('content')
  <h1>{{ __('users.edit') }}</h1>

  @include ('users/_form')
  @include ('users/_api')
@endsection
