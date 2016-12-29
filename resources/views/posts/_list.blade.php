@each('posts/_show', $posts, 'post')

<div class="text-center">
    {{ $posts->links() }}
</div>
