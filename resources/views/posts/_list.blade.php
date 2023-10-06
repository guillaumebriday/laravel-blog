<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @each('posts/_show', $posts, 'post', 'posts/_empty')
</div>

<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
