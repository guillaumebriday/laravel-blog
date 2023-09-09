@auth
    <form action="{{ route('newsletter-subscriptions.store') }}" method="POST" class="form-inline">
        @csrf

        <input
            type="email"
            name="email"
            class="form-control mr-sm-1 mb-1"
            placeholder="@lang('newsletter.placeholder')"
        >

        <input type="submit" class="btn btn-outline-secondary mb-1" value="@lang('newsletter.subscribe')">
    </form>
@endauth
