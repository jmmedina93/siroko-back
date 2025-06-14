FROM php:8.2-fpm

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /app