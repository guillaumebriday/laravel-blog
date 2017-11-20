@auth
    {!! Form::open(['route' => 'newsletter-subscriptions.store', 'method' => 'post', 'class' => 'form-inline']) !!}
        {!! Form::text('email', null, ['class' => 'form-control mr-sm-1 mb-1', 'placeholder' => __('newsletter.placeholder')]) !!}
        {!! Form::submit(__('newsletter.subscribe'), ['class' => 'btn btn-outline-secondary mb-1']) !!}
    {!! Form::close() !!}
@endauth
