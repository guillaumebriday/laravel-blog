@extends('layouts.app')

@section('content')
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>{{ user_name($user) }}</strong>
            </div>
            <div class="panel-body">
              @include ('users/_form')
            </div>
        </div>
      </div>
  </div>
@endsection
