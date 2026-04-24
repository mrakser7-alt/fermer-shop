FROM php:8.4-cli-bookworm

# Системные зависимости + расширения PHP
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libicu-dev libonig-dev \
    libxml2-dev libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_sqlite sqlite3 intl zip bcmath mbstring xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Устанавливаем зависимости и собираем фронтенд
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build

EXPOSE 8000

CMD ["bash", "start.sh"]
