<nav>
    <ul class="nav nav-pills nav-stacked">
        <li role="presentation" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                {{ __('dashboard.dashboard') }}
            </a>
        </li>
    </ul>
</nav>
