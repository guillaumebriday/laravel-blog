@extends('layouts.app')

@section('content')
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          @include ('posts/_show')
          @include ('comments/_list')
      </div>
  </div>
@endsection
