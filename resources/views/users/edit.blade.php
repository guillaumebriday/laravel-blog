@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>{{ user_name($user) }}</strong>
    </div>
    <div class="panel-body">
        @include ('users/_form')
    </div>
</div>
@endsection
