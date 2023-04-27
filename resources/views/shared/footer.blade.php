<nav class="navbar navbar-dark bg-dark position-absolute footer-container">
    <div class="container justify-content-center">
        <ul class="navbar-nav text-center">
            <li class="nav-item text-white m-3">
                <?php __('Made with') ?> <i class="fa fa-heart text-danger" aria-hidden="true"></i> <?php __('by') ?> <a
                    href="https://pardisania.ir" target="_blank" class="text-secondary"><?php __('Saber Tabatabaee') ?></a>
            </li>

            <li class="nav-item text-white m-3">
                <a href="https://github.com/saber13812002/laravel-blog" target="_blank"
                   class="btn btn-outline-secondary mt-1"><i class="fa fa-github" aria-hidden="true"></i> <?php __('Fork me on') ?>
                    <?php __('GitHub') ?></a>
                <a href="https://twitter.com/guillaumebriday" target="_blank" class="btn btn-outline-secondary mt-1"><i
                        class="fa fa-twitter" aria-hidden="true"></i> <?php __('Say Hi on Twitter !') ?></a>
            </li>

            <li class="nav-item m-3">
                @include('shared/newsletter-form')
            </li>
        </ul>
    </div>
</nav>
