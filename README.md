# NetElement Test

## Настройка проекта

Перед запуском приложиния необходимо произвести настройку бд
и окружения, установить зависимости.

```
composer install

cp example.db.php db.php
vim db.php

cp example.env.php env.php
vim env.php
```

## Анализаторы и тесты

Для запуска анализаторов и тестов используйте команду:

`./vendor/bin/phing`

Результаты будут находиться в папке `build` в корне проекта

