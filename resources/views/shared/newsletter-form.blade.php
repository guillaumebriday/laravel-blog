@if (Auth::check())
    {!! Form::open(['route' => 'newsletter-subscriptions.store', 'method' => 'post', 'class' => 'navbar-form navbar-right']) !!}
        <div class="form-group">
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('newsletter.placeholder')]) !!}
        </div>

        {!! Form::submit(trans('newsletter.subscribre'), ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}
@endif
