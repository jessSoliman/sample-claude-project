# Local development image: PHP 8.3 CLI with the extensions this app needs.
# Source is bind-mounted at runtime (see compose.yaml), not copied in.
FROM php:8.3-cli-bookworm

ARG UID=1000
ARG GID=1000

# gd: photo thumbnails (config/posts.php). pcntl: queue worker timeouts/signals.
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libjpeg62-turbo-dev libpng-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" gd pcntl \
    && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY php.ini "$PHP_INI_DIR/conf.d/zz-app.ini"

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY entrypoint.sh /usr/local/bin/app-entrypoint
RUN chmod +x /usr/local/bin/app-entrypoint

# Match the host user so files written to the bind mount (vendor/, storage/)
# aren't root-owned on Linux hosts. Irrelevant on Docker Desktop for Windows.
RUN groupadd --gid "$GID" app && useradd --uid "$UID" --gid "$GID" --create-home app
USER app

WORKDIR /var/www/html

ENTRYPOINT ["app-entrypoint"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
