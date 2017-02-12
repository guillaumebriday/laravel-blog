@component('components.panels.default', ['type' => 'info'])
    @slot('title')
        <strong>{{ link_to_route('posts.show', $post->title, $post) }}</strong>,
        <span>{{ link_to_route('users.show', user_name($post->author), $post->author) }}</span>
        <time class="pull-right">{{ humanize_date($post->posted_at) }}</time>
    @endslot

    {{ $post->content }}
@endcomponent
