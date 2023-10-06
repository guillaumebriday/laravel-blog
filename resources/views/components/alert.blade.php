<div @class(["alert alert-{$type}", 'alert-dismissible' => $dismissible]) role="alert">
    @if ($dismissible)
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    @endif

    @if (isset($title))
        <strong>{{ $title }}</strong>
    @endif

    {{ $slot }}
</div>
