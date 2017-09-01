@extends('layouts.app')

@section('content')
  <h1 class="mb-3">{{ __('users.show') }}</h1>

  @include ('users/_profil')

  @can('update', $user)
   {{ link_to_route('users.edit', __('users.edit'), ['user' => $user], ['class' => 'btn btn-primary']) }}
  @endcan
@endsection
