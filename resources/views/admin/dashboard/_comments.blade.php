<div class="col-md-6">
    @component('components.panels.default', ['type' => 'primary'])
        @slot('title')
        <div class="row">
            <div class="col-xs-3">
                <i class="fa fa-comments fa-5x" aria-hidden="true"></i>
            </div>
            <div class="col-xs-9 text-right">
                <div class="huge">{{ $comments->count() }}</div>
                <div>{{ trans_choice('comments.new_comments', $comments->count()) }}</div>
            </div>
        </div>
        @endslot

        <a href="{{ route('admin.comments.index') }}">
            <span class="pull-left">{{ __('dashboard.details') }}</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </a>
    @endcomponent
</div>
