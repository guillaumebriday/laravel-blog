<div class="col-md-6">
    @component('components.panels.success')
        @slot('title')
        <div class="row">
            <div class="col-xs-3">
                <i class="fa fa-file-text-o fa-5x" aria-hidden="true"></i>
            </div>
            <div class="col-xs-9 text-right">
                <div class="huge">{{ $posts->count() }}</div>
                <div>{{ trans_choice('posts.new_posts', $posts->count()) }}</div>
            </div>
        </div>
        @endslot

        <a href="#">
            <span class="pull-left">{{ __('dashboard.details') }}</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </a>
    @endcomponent
</div>
