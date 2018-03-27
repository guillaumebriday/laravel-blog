<table class="table table-striped table-sm table-responsive-md">
    <caption>{{ trans_choice('media.count', $media->count()) }}</caption>
    <thead>
        <tr>
            <th>@lang('media.attributes.image')</th>
            <th>@lang('media.attributes.name')</th>
            <th>@lang('media.attributes.url')</th>
            <th>@lang('media.attributes.posted_at')</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($media as $medium)
            <tr>
                <td>
                    <a href="{{ $medium->getUrl() }}" target="_blank">
                        <img src="{{ $medium->getUrl('thumb') }}" alt="{{ $medium->name }}" width="100">
                    </a>
                </td>
                <td>{{ $medium->name }}</td>
                <td>
                    <div class="input-group">
                        {{ Form::text(null, url($medium->getUrl()), ['class' => 'form-control', 'readonly' => true, 'id' => "medium-{$medium->id}"]) }}
                        <div class="input-group-append">
                            <button class="input-group-text btn" data-clipboard-target="#medium-{{ $medium->id }}">
                                <i class="fa fa-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td>{{ humanize_date($medium->posted_at, 'd/m/Y H:i:s') }}</td>
                <td>
                    <a href="{{ $medium->getUrl() }}" title="{{ __('media.show') }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>

                    <a href="{{ route('admin.media.show', $medium) }}" title="{{ __('media.download') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>

                    {!! Form::model($medium, ['method' => 'DELETE', 'route' => ['admin.media.destroy', $medium], 'class' => 'form-inline', 'data-confirm' => __('forms.media.delete')]) !!}
                        {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-sm', 'name' => 'submit', 'type' => 'submit', 'title' => __('media.delete')]) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
