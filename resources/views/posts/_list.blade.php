@each('posts/_show', $posts, 'post', 'posts/_empty')

<div class="text-center">
    {{ $posts->links() }}
</div>
