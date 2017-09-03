<nav class="col-lg-2 d-none d-lg-block bg-dark sidebar">
  <ul class="nav nav-pills flex-column">
        <li role="presentation" class="nav-item">
            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa fa-tachometer" aria-hidden="true"></i>&nbsp;
                {{ __('dashboard.dashboard') }}
            </a>
        </li>

        <li role="presentation" class="nav-item">
            <a class="nav-link {{ Request::is('admin/posts') || Request::is('admin/posts/*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                <i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;
                {{ __('dashboard.posts') }}
            </a>
        </li>

        <li role="presentation" class="nav-item">
            <a class="nav-link {{ Request::is('admin/comments') || Request::is('admin/comments/*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                <i class="fa fa-comments" aria-hidden="true"></i>&nbsp;
                {{ __('dashboard.comments') }}
            </a>
        </li>

        <li role="presentation" class="nav-item">
            <a class="nav-link {{ Request::is('admin/users') || Request::is('admin/users/*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fa fa-users" aria-hidden="true"></i>&nbsp;
                {{ __('dashboard.users') }}
            </a>
        </li>
    </ul>
</nav>
