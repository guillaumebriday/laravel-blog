@auth
    <form action="{{ route('newsletter-subscriptions.store') }}" method="POST" class="form-inline">
        @csrf

        <input
            type="email"
            name="email"
            class="form-control me-sm-1 mb-1"
            placeholder="@lang('newsletter.placeholder')"
        >

        <button type="submit" class="btn btn-outline-secondary mb-1">
            <x-icon name="paper-plane" />

            @lang('newsletter.subscribe')
        </button>
    </form>
@endauth
