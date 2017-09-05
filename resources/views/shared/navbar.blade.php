<nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-md">
    <div class="container">
        <!-- Branding Image -->
        {{ link_to_route('home', config('app.name', 'Laravel'), [], ['class' => 'navbar-brand']) }}

        <!-- Collapsed Hamburger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            @if (Auth::check() && Auth::user()->isAdmin())
                <ul class="navbar-nav">
                    <li class="nav-item">
                        {{ link_to_route('admin.dashboard', __('dashboard.dashboard'), [], ['class' => 'nav-link']) }}
                    </li>
                </ul>
            @endif

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">{{ link_to_route('login', __('auth.login'), [], ['class' => 'nav-link']) }}</li>
                    <li class="nav-item">{{ link_to_route('register', __('auth.register'), [], ['class' => 'nav-link']) }}</li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            {{ link_to_route('users.show', __('users.profil'), Auth::user(), ['class' => 'dropdown-item']) }}
                            <a href="{{ url('/logout') }}"
                                class="dropdown-item"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('auth.logout') }}
                            </a>

                            <form id="logout-form" class="d-none" action="{{ url('/logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

