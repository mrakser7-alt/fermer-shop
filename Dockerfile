FROM alpine:3.21
RUN apk add --no-cache bash git curl unzip php84 php84-cli php84-pdo php84-pdo_sqlite php84-intl php84-zip php84-bcmath php84-mbstring php84-xml php84-dom php84-tokenizer php84-simplexml php84-xmlwriter php84-xmlreader php84-fileinfo php84-openssl php84-session php84-ctype php84-phar php84-iconv php84-curl php84-pcntl php84-sodium php84-sqlite3 && ln -sf /usr/bin/php84 /usr/local/bin/php
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --no-scripts --no-interaction
EXPOSE 8000
CMD ["bash", "start.sh"]
