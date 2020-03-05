<div class="alert alert-{{ $type }} alert-dismissible" role="alert">
    @if (isset($dismissible) && $dismissible)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    @endif

    @if (isset($title))
        <strong>{{ $title }}</strong>
    @endif

    {{ $slot }}
</div>
