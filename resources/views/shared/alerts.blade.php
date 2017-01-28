@if (Session::has('success'))
    @component('components.alerts.success')
      {{ Session::get('success') }}
    @endcomponent
@endif

@if (Session::has('errors'))
    @component('components.alerts.errors')
        {{ trans_choice('validation.errors', $errors->count()) }}
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endcomponent
@endif
