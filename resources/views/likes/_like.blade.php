@auth
    <x-turbo-frame :id="[$post, 'like']">
        @if ($post->isLiked())
            {!! Form::open(['route' => ['posts.likes.destroy', $post], 'method' => 'DELETE', 'class' => 'form-inline', 'data-turbo' => 'true']) !!}
                {!! Form::button('<i class="fa ml-2 fa-heart text-danger" aria-hidden="true"></i>', ['class' => 'btn btn-link p-0', 'name' => 'submit', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        @else
            {!! Form::open(['route' => ['posts.likes.store', $post], 'method' => 'POST', 'class' => 'form-inline', 'data-turbo' => 'true']) !!}
                {!! Form::button('<i class="fa ml-2 fa-heart-o" aria-hidden="true"></i>', ['class' => 'btn btn-link p-0', 'name' => 'submit', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        @endif
    </x-turbo-frame>
@else
    <i
        class="fa ml-2 fa-heart-o"
        aria-hidden="true"
    ></i>
@endauth
