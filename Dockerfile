FROM php:8.2-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia o projeto
COPY . .

RUN composer install --no-interaction

CMD ["php-fpm"]
