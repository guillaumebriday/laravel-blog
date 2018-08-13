<div class="card {{ $class ?? '' }}">
    @if (isset($title))
        <div class="card-header">
            {{ $title }}
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if (isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
