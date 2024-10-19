FROM serversideup/php:8.3-fpm-nginx AS base

# Switch to root so we can do root things
USER root

# Install the exif extension with root permissions
RUN install-php-extensions exif

# Install JavaScript dependencies
ARG NODE_VERSION=20.18.0
ENV PATH=/usr/local/node/bin:$PATH
RUN curl -sL https://github.com/nodenv/node-build/archive/master.tar.gz | tar xz -C /tmp/ && \
    /tmp/node-build-master/bin/node-build "${NODE_VERSION}" /usr/local/node && \
    corepack enable && \
    rm -rf /tmp/node-build-master

# Drop back to our unprivileged user
USER www-data

FROM base

ENV SSL_MODE="off"
ENV AUTORUN_ENABLED="true"
ENV PHP_OPCACHE_ENABLE="1"
ENV HEALTHCHECK_PATH="/up"

# Copy the app files...
COPY --chown=www-data:www-data . /var/www/html

# Re-run install, but now with scripts and optimizing the autoloader (should be faster)...
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Precompiling assets for production
RUN yarn install --immutable && \
    yarn build && \
    rm -rf node_modules
