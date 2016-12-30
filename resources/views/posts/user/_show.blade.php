<div class="panel panel-info">
    <div class="panel-heading">
        <b><a href="{{ route('posts.show', ['id' => $post->id]) }}">{{ $post->title }}</a></b>,
        {{ $post->comments()->count() }} <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
        <time class="pull-right">{{ humanize_date($post->posted_at) }}</time>
    </div>
    <div class="panel-body">
        {{ $post->content }}
    </div>
</div>
