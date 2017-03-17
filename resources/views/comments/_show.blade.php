@component('components.panels.default')
    @slot('title')
        <span>{{ link_to_route('users.show', $comment->author->fullname, $comment->author) }}</span>
        <span class="pull-right">
            <time>{{ humanize_date($comment->posted_at) }}</time>

            @can('delete', $comment)
                {!! Form::model($comment, ['method' => 'DELETE', 'route' => ['comments.destroy', $comment->id], 'class' => 'form-inline', 'data-confirm' => __('forms.comments.delete')]) !!}
                    {!! Form::button('<span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span>', ['class' => 'btn btn-link', 'name' => 'submit', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            @endcan
        </span>
    @endslot

    {{ $comment->content }}
@endcomponent
