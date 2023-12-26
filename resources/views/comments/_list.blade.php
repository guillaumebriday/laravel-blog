<h2 id="comments_count" class="mt-2">
    {{ trans_choice('comments.count', $post->comments_count) }}
</h2>

<x-turbo-frame id="comments" :src="route('posts.comments.index', $post)" loading="lazy">
    <x-alert type="info">
        <x-icon name="spinner" class="fa-spin" />

        @lang('comments.loading_comments')
    </x-alert>
</x-turbo-frame>

@include ('comments/_form')
