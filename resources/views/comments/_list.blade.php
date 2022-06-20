<h2 id="comments_count" class="mt-2">{{ trans_choice('comments.count', $post->comments_count) }}</h2>

@include ('comments/_form')

<x-turbo-frame id="comments" :src="route('posts.comments.index', $post)" loading="lazy">
    <x-alert type="info">
        <i class="fa fa-spinner fa-spin fa-fw"></i>
        @lang('comments.loading_comments')
    </x-alert>
</x-turbo-frame>
