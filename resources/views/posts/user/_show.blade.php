@component('components.panels.default', ['type' => 'info'])
    @slot('title')
        <strong>{{ link_to_route('posts.show', $post->title, $post) }}</strong>,
        {{ $post->comments_count }} <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
        <time class="pull-right">{{ humanize_date($post->posted_at) }}</time>
    @endslot

    {{ $post->content }}
@endcomponent
