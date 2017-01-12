@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('posts.last_posts') }}</div>

                <div class="panel-body">
                    @include ('posts/_list')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
