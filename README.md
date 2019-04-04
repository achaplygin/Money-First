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


Установка проекта
---
1. Скопировать/распаковать файлы проекта. 
2. В директории проекта выполнить:
```
composer install
```
Подготовка приложения
---
- Выполнить инициализацию:
```
php /_project_dir_/init --env=Development --overwrite=All
```
***
- Создать в PostgreSQL пользователя yii с паролем yii и новую БД с названием yii
_(и что бы нормально работало, пользователю надо дать привилегии в базе)_:
```
CREATE USER "yii" WITH password 'yii';
CREATE DATABASE "yii" WITH owner = "yii";
GRANT ALL privileges ON DATABASE "yii" TO "yii";
```

Ну, или поменять конфиг подключения в: _./common/config/main-local.php_ для других пользователя и базы, на свой вкус.
```
'dsn' => 'pgsql:host=localhost;dbname=yii',
'username' => 'yii',
'password' => 'yii',
```

***
- Применить миграции
```
./yii migrate
```
***
- Настроить веб-сервер

  - Для фронта корневая директория ```/_project_dir_/frontend/web/``` и URL ```http://moneyfirst.test/```
  - Для админки корневая директория ```/_project_dir_/backend/web/``` и URL ```http://admin.moneyfirst.test/```

Есть готовые конфиги для nginx: ```/_project_dir_/vagrant/nginx/app.conf```
***
- Добавить домены в файл _/etc/hosts_:
```
127.0.0.1   moneyfirst.test
127.0.0.1   admin.moneyfirst.test
```
Перезапустить веб-сервер, разумеется.
***
Готово
---
В системе сразу есть один админ:

    login: admin
    pass: 123456 


Что сделано, что не сделано
---------------------------


