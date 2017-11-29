<table class="table table-striped table-sm">
    <caption>{{ trans_choice('users.count', $users->total()) }}</caption>
    <thead>
        <tr>
            <th>@lang('users.attributes.name')</th>
            <th>@lang('users.attributes.email')</th>
            <th>@lang('users.attributes.registered_at')</th>
            <th><i class="fa fa-file" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <th>{{ link_to_route('admin.users.edit', $user->fullname, $user) }}</th>
                <td>{{ $user->email }}</td>
                <td>{{ humanize_date($user->registered_at, 'd/m/Y H:i:s') }}</td>
                <td><span class="badge badge-pill badge-secondary">{{ $user->posts_count }}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>
