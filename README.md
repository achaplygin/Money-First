<p align="center">
    <a href="https://github.com/achaplygin/Money-First" target="_blank">
        <img src="https://i.imgur.com/xjhLmBT.png" height="100px">
    </a>
    <h1 align="center">Project "Money First"</h1>
    <br>
</p>

Used:
-----

- PHP 7.2
- Nginx 1.14
- PostgreSQL 10.7
- Composer 1.8 
- Yii 2 Advanced Template


Установка с помощью Composer
---
Установить файлы проекта:
```
composer create-project --prefer-dist achaplygin/Money-First _project_dir_
```

Установка из архива
---
1. Скопировать файлы проекта. 
2. В директории проекта выполнить:
```
composer install
```
Подготовка приложения
---
- Выполнить инициализацию:
```
php /_project_dir_/init
```
***
- Создать новую БД и пользователя yii:
```
'dsn' => 'pgsql:host=localhost;dbname=yii',
'username' => 'yii',
'password' => 'yii',
```
Ну, или поменять конфиг подключения в: _./common/config/main-local.php_ для своих пользователя и базы.
***
- Применить миграции
```
./yii migrate
```
***
- Настроить веб-сервер

  - Для фронта корневая директория ```/_project_dir_/frontend/web/``` и URL ```http://first.test/```
  - Для админки корневая директория ```/_project_dir_/backend/web/``` и URL ```http://admin.test/```

Есть готовые конфиги для nginx: ```/_project_dir_/vagrant/nginx/app.conf```
***
- Добавить домены в файл _/etc/hosts_:
```
127.0.0.1   first.test
127.0.0.1   admin.test
```
***
Готово
---
В системе сразу есть один админ:

    login: admin
    pass: 123456 


Что сделано, что не сделано
---------------------------

```
Всё сделал, потому что могу.

```
