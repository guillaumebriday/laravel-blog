<div class="panel panel-default">
    <div class="panel-heading">
        <span>{{ user_name($comment->author) }}</span>
        <time class="pull-right">{{ humanize_date($comment->posted_at) }}</time>
    </div>
    <div class="panel-body">
        {{ $comment->content }}
    </div>
</div>
