#!/bin/bash
set -e

# Создаём .env из примера, если файл отсутствует
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Генерируем APP_KEY если не задан через переменные Railway
php artisan key:generate --force --no-interaction 2>/dev/null || true

# Создаём SQLite файл если отсутствует
touch database/database.sqlite

# Регистрируем пакеты (нужно после --no-scripts при сборке)
php artisan package:discover --ansi 2>/dev/null || true

# Применяем миграции (idempotent — не трогает существующие данные)
php artisan migrate --force --no-interaction

# Заполняем начальными данными (idempotent — не создаёт дубли)
php artisan db:seed --force --no-interaction

# Симлинк для загруженных файлов (фото товаров)
php artisan storage:link --force 2>/dev/null || true

# Права на запись для логов и кэша
chmod -R 775 storage bootstrap/cache

# Запускаем сервер (PORT задаётся Railway автоматически)
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
