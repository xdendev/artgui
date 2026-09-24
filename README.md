# ArtGui
This package is fork https://github.com/infureal/artisan-gui

## Установка

### 1. Установка через Composer

```bash
composer require xden/artgui
```

### 2. Публикация ресурсов и настройка

```bash
# Публикация конфигурации
php artisan vendor:publish --tag=config --provider="Xden\ArtGui\ArtGuiServiceProvider"
# Публикация assets
php artisan vendor:publish --tag=assets --provider="Xden\ArtGui\ArtGuiServiceProvider"
```

### 3. Установка зависимостей и сборка (dev)

```bash
docker-compose run --rm npm install ansicolor
docker-compose run --rm build
```

### 4. Включение и доступ

По умолчанию пакет **выключен**, роуты не регистрируются. Включается явно через `.env` только там, где GUI нужен (например, на dev-стенде):

```dotenv
ARTGUI_PACKAGE_ENABLED=true
ARTGUI_USERNAME=tester
ARTGUI_PASSWORD=long-random-password
```

На роуты GUI всегда вешается HTTP Basic auth, отключить его через `middlewares` нельзя. Если логин или пароль не задан, GUI отвечает `403` на любой запрос.

### 5. Список команд

По умолчанию список `commands` пустой. Опубликуйте конфиг и перечислите только те команды, которые безопасно запускать из браузера:

```php
'commands' => [
    'cache' => ['cache:clear', 'config:clear'],
    'info' => ['route:list', 'migrate:status'],
],
```

Ограничения:
- команда выполняется синхронно внутри HTTP-запроса, поэтому долгие команды упрутся в таймауты PHP и веб-сервера;
- запуск неинтерактивный: `confirm()`/`ask()` молча возвращают значение по умолчанию;
- аргумент-массив вводится одной строкой через пробел.

## Использование

После включения GUI доступен по адресу:

```
http://your-app.test/artgui
```

## Тесты

```bash
docker run --rm -v "$PWD":/app -w /app composer:latest sh -c "composer install && vendor/bin/phpunit"
```

## Лицензия

MIT License
