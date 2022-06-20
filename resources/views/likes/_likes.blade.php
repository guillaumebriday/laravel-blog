@include('likes/_like')

<span id="@domid($post, 'likes_count')">{{ $post->likes_count }}</span>

