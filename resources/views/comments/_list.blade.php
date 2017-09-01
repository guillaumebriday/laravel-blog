<h2 class="mt-2">{{ trans_choice('comments.count', $comments->total()) }}</h2>

@include ('comments/_form')

@each('comments/_show', $comments, 'comment')

<div class="d-flex justify-content-center mt-2">
    {{ $comments->links() }}
</div>
