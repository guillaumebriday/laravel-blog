@extends('layouts.app')

@section('content')
    @include ('posts/_show')
    @include ('comments/_list')
@endsection
