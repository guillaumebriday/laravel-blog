<x-turbo-frame id="comments">
    <div class="space-y-3">
        @each('comments/_comment', $comments, 'comment', 'posts/_empty')
    </div>
</x-turbo-frame>
