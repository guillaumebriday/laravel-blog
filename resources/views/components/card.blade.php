<div {{ $attributes->merge(['class' => 'card']) }}>
    @if (isset($title))
        <div class="card-header">
            {{ $title }}
        </div>
    @endif

    @if (isset($image))
        {{ $image }}
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
