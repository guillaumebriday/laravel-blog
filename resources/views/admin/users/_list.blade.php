<table class="table table-striped">
    <caption>{{ trans_choice('users.count', $users->total()) }}</caption>
    <thead>
        <tr>
            <th>{{ __('users.attributes.name') }}</th>
            <th>{{ __('users.attributes.email') }}</th>
            <th>{{ __('users.attributes.registered_at') }}</th>
            <th><i class="fa fa-file" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <th>{{ link_to_route('admin.users.edit', $user->fullname, $user) }}</th>
                <td>{{ $user->email }}</td>
                <td>{{ humanize_date($user->registered_at, 'd/m/Y H:i:s') }}</td>
                <td><span class="badge">{{ $user->posts_count }}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center">
    {{ $users->links() }}
</div>
