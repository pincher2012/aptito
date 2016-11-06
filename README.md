# NetElement Test

Перед запуском приложиния необходимо произвести настройку бд
и окружения

```
cp example.db.php db.php
vim db.php

cp example.env.php env.php
vim env.php
```

Для запуска анализаторов и тестов используйте команду:

`./vendor/bin/phing`
