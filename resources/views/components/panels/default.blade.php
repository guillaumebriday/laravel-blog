<div class="panel panel-{{ $type or 'default' }}">
    @if (isset($title))
        <div class="panel-heading">
            {{ $title }}
        </div>
    @endif
    <div class="panel-body">
        {{ $slot }}
    </div>
</div>
