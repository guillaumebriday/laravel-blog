<x-turbo-frame id="comments">
    @each('comments/_comment', $comments, 'comment', 'posts/_empty')
</x-turbo-frame>
