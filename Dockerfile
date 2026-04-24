FROM php:8.4-cli-bookworm
RUN apt-get update && apt-get install -y git curl unzip libzip-dev libicu-dev libonig-dev libxml2-dev libsqlite3-dev && docker-php-ext-install pdo pdo_sqlite sqlite3 intl zip bcmath mbstring xml && apt-get clean && rm -rf /var/lib/apt/lists/*
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
EXPOSE 8000
CMD ["bash", "start.sh"]
