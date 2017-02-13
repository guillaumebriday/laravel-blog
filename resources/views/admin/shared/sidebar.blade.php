<nav>
    <ul class="nav nav-pills nav-stacked">
        <li role="presentation" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                {{ __('dashboard.dashboard') }}
            </a>
        </li>

        <li role="presentation" class="{{ Request::is('admin/posts') || Request::is('admin/posts/*') ? 'active' : '' }}">
            <a href="{{ route('admin.posts.index') }}">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                {{ __('dashboard.posts') }}
            </a>
        </li>

        <li role="presentation" class="{{ Request::is('admin/comments') || Request::is('admin/comments/*') ? 'active' : '' }}">
            <a href="{{ route('admin.comments.index') }}">
                <i class="fa fa-comments" aria-hidden="true"></i>
                {{ __('dashboard.comments') }}
            </a>
        </li>

        <li role="presentation" class="{{ Request::is('admin/users') || Request::is('admin/users/*') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                {{ __('dashboard.users') }}
            </a>
        </li>
    </ul>
</nav>
