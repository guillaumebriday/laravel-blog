<x-card class="bg-success text-light m-2">
    <div class="row justify-content-between">
        <x-icon name="file-text" prefix="fa-regular" class="fa-5x" />

        <div class="col text-end">
            <div class="fa-2x">{{ $posts->count() }}</div>
            <div>{{ trans_choice('posts.new_posts', $posts->count()) }}</div>
        </div>
    </div>

    <x-slot:footer>
        <a href="{{ route('admin.posts.index') }}" class="d-flex justify-content-between text-light">
            <span>@lang('dashboard.details')</span>

            <span><x-icon name="arrow-circle-right" /></span>
        </a>
    </x-slot>
</x-card>
