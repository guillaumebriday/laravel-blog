<x-card class="bg-warning text-light m-2">
    <div class="row justify-content-between">
        <x-icon name="users" class="fa-5x" />

        <div class="text-right">
            <div class="huge">{{ $users->count() }}</div>
            <div>{{ trans_choice('users.new_users', $users->count()) }}</div>
        </div>
    </div>

    <x-slot:footer>
        <a href="{{ route('admin.users.index') }}" class="d-flex justify-content-between text-light">
            <span>@lang('dashboard.details')</span>

            <span><x-icon name="arrow-circle-right" /></span>
        </a>
    </x-slot>
</x-card>
