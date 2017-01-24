<form class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">{{ trans('users.attributes.name') }} : </label>
    <div class="col-sm-8">
      <p class="form-control-static">{{ $user->name }}</p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">{{ trans('users.attributes.email') }} : </label>
    <div class="col-sm-8">
      <p class="form-control-static">{{ $user->email }}</p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">{{ trans('users.nb_of_posts') }} : </label>
    <div class="col-sm-8">
      <p class="form-control-static">{{ $user->posts()->count() }}</p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">{{ trans('users.nb_of_comments') }} : </label>
    <div class="col-sm-8">
      <p class="form-control-static">{{ $user->comments()->count() }}</p>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email">{{ trans('users.attributes.roles') }} : </label>
    <div class="col-sm-8">
      <ul class="list-unstyled form-control-static">
        @foreach($roles as $role)
          <li>
            {!! Form::checkbox(null, $role->name, $user->hasRole($role->name), ['disabled' => true]) !!}
            @if (Lang::has('roles.' . $role->name))
              {!! trans('roles.' . $role->name) !!}
            @else
              {{ ucfirst($role->name) }}
            @endif
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  @can('update', $user)
    <a href="{{ route('users.edit', $user) }}" class="pull-right btn btn-primary">{{ trans('users.edit') }}</a>
  @endcan
</form>
