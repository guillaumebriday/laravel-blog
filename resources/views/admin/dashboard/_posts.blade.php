<x-card class="bg-success text-light m-2">
    <div class="row justify-content-between">
        <i class="fa fa-file-text fa-5x" aria-hidden="true"></i>
        <div class="text-right">
            <div class="huge">{{ $posts->count() }}</div>
            <div>{{ trans_choice('posts.new_posts', $posts->count()) }}</div>
        </div>
    </div>

    <x-slot name="footer">
        <a href="{{ route('admin.posts.index') }}" class="d-flex justify-content-between text-light">
            <span>@lang('dashboard.details')</span>
            <span><i class="fa fa-arrow-circle-right"></i></span>
        </a>
    </x-slot>
</x-card>
