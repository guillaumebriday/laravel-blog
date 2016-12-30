<div class="panel panel-default">
    <div class="panel-heading">
        <b><a href="{{ route('posts.show', ['id' => $comment->post->id]) }}">{{ $comment->post->title }}</a></b>,
        <span>{{ user_name($comment->post->author) }}</span>
        <time class="pull-right">{{ humanize_date($comment->posted_at) }}</time>
    </div>
    <div class="panel-body">
        {{ $comment->content }}
    </div>
</div>
