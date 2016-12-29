<h2>{{ trans_choice('comments.count', $comments->total()) }}</h2>

@each('comments/_show', $comments, 'comment')

<div class="text-center">
    {{ $comments->links() }}
</div>
