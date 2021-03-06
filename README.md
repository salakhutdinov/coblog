Тестовое задание в компанию CỐC CỐC
===================================

Надо написать с нуля (не используя фреймворков и библиотек) блог.

Четыре страницы:

Список постов
Открытый пост с комментариями
Добавление поста
Авторизация


Функционал простой:

1) Авторизованный пользователь может добавить пост

2) Кто угодно может его комментировать.


NB Важно написать его красиво с точки зрения архитектуры приложения и правильного применения ООП. Это определяющий критерий.

Требования к проекту
--------------------

* PHP 5.6
* MongoDB 3.0

Запуск проекта
--------------

Строку подключения и имя базы данных можно указать в конфиге `var/config/config.php`

```php
    'db_server' => 'mongodb://localhost:27017',
    'db_name' => 'coblog',
```

Проект можно запустить при помощи встроенного веб-сервера

```
php -S localhost:8000 web/app.php
```

Тестовые фикстуры можно загрузит с помощью php-скрипта `load-fixtures.php`

```shell
php var/load-fixtures.php
```

Фикстуры создают нового пользователя `test@example.com` с паролем `test`

Тесты
-----

Для тестов используется внешняя библиотека `phpunit`. Установка производится с помощью Composer:

```
composer install
```

Запуск тестов:

```
vendor/bin/phpunit
```
