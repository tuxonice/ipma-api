FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libxml2-dev \
    libonig-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Xdebug for code coverage
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install PHP extensions
RUN docker-php-ext-install \
    dom \
    mbstring \
    simplexml \
    xml \
    zip

# Install Composer (specific version to avoid deprecation notices)
COPY --from=composer:2.8.11 /usr/bin/composer /usr/bin/composer

# Install gosu for privilege dropping in entrypoint
COPY --from=tianon/gosu:1.17 /usr/local/bin/gosu /usr/local/bin/gosu

# Set working directory
WORKDIR /app

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["./vendor/bin/phpunit"]
