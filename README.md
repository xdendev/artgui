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

## Использование

После установки, демо страница будет доступна по адресу:

```
http://your-app.test/artgui
```

## Лицензия

MIT License
