@component('components.panels.default')
    @slot('title')
        <strong>{{ link_to_route('posts.show', $comment->post->title, $comment->post) }}</strong>,
        <span>{{ link_to_route('users.show', user_name($comment->post->author), $comment->post->author) }}</span>
        <time class="pull-right">{{ humanize_date($comment->posted_at) }}</time>
    @endslot

  {{ $comment->content }}
@endcomponent
