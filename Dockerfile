FROM node:26-slim AS node

FROM serversideup/php:8.6-fpm-nginx AS base

# Switch to root so we can do root things
USER root

# Install PHP extensions (exif and gd are required by spatie/laravel-medialibrary)
RUN install-php-extensions exif gd intl

# Install JavaScript dependencies
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm && \
    npm install --global corepack && \
    corepack enable

# Drop back to our unprivileged user
USER www-data

FROM base

ENV SSL_MODE="off"
ENV AUTORUN_ENABLED="true"
ENV PHP_OPCACHE_ENABLE="1"
ENV HEALTHCHECK_PATH="/up"

# Copy the app files...
COPY --chown=www-data:www-data . /var/www/html

# Install PHP dependencies, without dev packages, with an optimized autoloader
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# Precompiling assets for production
RUN yarn install --immutable && \
    yarn build && \
    rm -rf node_modules
