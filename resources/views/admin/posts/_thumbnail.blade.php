@if ($post->hasThumbnail())
    {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'img-thumbnail', 'width' => '350']) }}

    {!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts_thumbnail.destroy', $post], 'data-confirm' => __('forms.posts.delete_thumbnail')]) !!}
        {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('posts.delete_thumbnail'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
    {!! Form::close() !!}
@endif
