<nav class="navbar navbar-dark bg-dark position-absolute footer-container">
    <div class="container justify-content-center">
        <ul class="navbar-nav text-center">
            <li class="nav-item text-white m-3">
                Made with <x-icon name="heart" prefix="fa-regular" class="text-danger" /> by <a href="https://guillaumebriday.fr" target="_blank" class="text-secondary">Guillaume Briday</a>
            </li>

            <li class="nav-item text-white m-3">
                <a href="https://github.com/guillaumebriday/laravel-blog" target="_blank" class="btn btn-outline-secondary mt-1">
                    <x-icon name="github" prefix="fa-brands" />

                    Fork me on GitHub
                </a>

                <a href="https://twitter.com/guillaumebriday" target="_blank" class="btn btn-outline-secondary mt-1">
                    <x-icon name="twitter" prefix="fa-brands" />

                    Say Hi on Twitter !
                </a>
            </li>

            <li class="nav-item m-3">
                @include('shared/newsletter-form')
            </li>
        </ul>
    </div>
</nav>
