<x-card class="bg-primary text-light m-2">
    <div class="row justify-content-between">
        <x-icon name="comments" prefix="fa-regular" class="fa-5x" />

        <div class="col text-end">
            <div class="fa-2x">{{ $comments->count() }}</div>
            <div>{{ trans_choice('comments.new_comments', $comments->count()) }}</div>
        </div>
    </div>

    <x-slot:footer>
        <a href="{{ route('admin.comments.index') }}" class="d-flex justify-content-between text-light">
            <span>@lang('dashboard.details')</span>

            <span><x-icon name="arrow-circle-right" /></span>
        </a>
    </x-slot>
</x-card>
