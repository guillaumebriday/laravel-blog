<div class="alert alert-{{ $type }}" role="alert">
    @if (isset($title))
        <strong>{{ $title }}</strong>
    @endif

    {{ $slot }}
</div>
