@auth
    {!! Form::open(['route' => 'newsletter-subscriptions.store', 'method' => 'post', 'class' => 'form-inline ml-auto']) !!}
        {!! Form::text('email', null, ['class' => 'form-control mr-sm-2', 'placeholder' => __('newsletter.placeholder')]) !!}
        {!! Form::submit(__('newsletter.subscribre'), ['class' => 'btn btn-secondary']) !!}
    {!! Form::close() !!}
@endauth
