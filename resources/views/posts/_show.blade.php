<div class="card">
  @if ($post->hasThumbnail())
    <a href="{{ route('posts.show', $post)}}">
      {{ Html::image($post->thumbnail->getUrl('thumb'), $post->thumbnail->name, ['class' => 'card-img-top']) }}
    </a>
  @endif

  <div class="card-body">
    <h4 v-pre class="card-title">{{ link_to_route('posts.show', $post->title, $post) }}</h4>

    <p class="card-text"><small v-pre class="text-muted">{{ link_to_route('users.show', $post->author->fullname, $post->author) }}</small></p>
    <div v-pre class="card-text post-content">{!! $post->content !!}</div>

    <p class="card-text">
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small><br>
      <small class="text-muted">
        <i class="fa fa-comments-o" aria-hidden="true"></i> {{ $post->comments_count }}
        <like
          likes_count="{{ $post->likes_count }}"
          liked="{{ $post->isLiked() }}"
          item_id="{{ $post->id }}"
          item_type="posts"
          logged_in="{{ Auth::check() }}"
        ></like>
      </small>
    </p>
  </div>
</div>
