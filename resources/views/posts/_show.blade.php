<div class="card">
  @if ($post->hasThumbnail())
    <a href="{{ route('posts.show', $post)}}">
      {{ Html::image($post->thumbnail->getUrl('thumb'), $post->thumbnail->name, ['class' => 'card-img-top']) }}
    </a>
  @endif

  <div class="card-body">
    <h4 v-pre class="card-title">
      <a href="{{ route('posts.show', $post) }}">
        {{ $post->title }}
      </a>
    </h4>

    <p class="card-text">
      <small v-pre class="text-muted">
        <a href="{{ route('users.show', $post->author) }}">
          {{ $post->author->fullname }}
        </a>
      </small>
    </p>

    <div class="card-text">
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small><br>
      <small class="text-muted">
        <i class="fa-regular fa-comments" aria-hidden="true"></i> {{ $post->comments_count }}
        @include('likes/_likes')
      </small>
    </div>
  </div>
</div>
