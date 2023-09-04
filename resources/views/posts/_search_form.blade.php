{!! Form::open(['route' => 'home', 'class' => 'd-flex', 'method' => 'GET', 'data-turbo' => 'true', 'data-turbo-frame' => 'posts', 'data-turbo-action' => 'advance']) !!}
  <div class="input-group mr-sm-3">
    {!! Form::text('q', null, ['class' => 'form-control', 'placeholder' => __('posts.search')]) !!}
  </div>

  <button type="submit" class="btn btn-primary">
    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
  </button>
{!! Form::close() !!}
