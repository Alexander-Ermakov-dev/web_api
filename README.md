# Apricode Web API

Apricode Web API - это веб-сервис для управления играми и их жанрами, построенный на Yii2 Basic.

## Установка

1. **Клонируйте репозиторий**:
``` 
  git clone https://github.com/Alexander-Ermakov-dev
```

2. Установите зависимости с помощью composer:
``` 
   composer install
```

3. Настройте подключение к базе данных, отредактировав `config/db.php`:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=apricode',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

4. Примените миграции для создания таблиц и наполнения их начальными данными:
```
yii migrate
```
### API Endpoints

#### ИГРЫ

- **Получить все игры и связанные с ними жанры (GET)**:
  `http://apricode.test/web/game`

- **Получить одну игру по id (GET)**:
  `http://apricode.test/web/game/view/ID_Игры`

- **Создать игру. Параметры: name, developer, genreIds[] (POST)**:
  `http://apricode.test/web/game/create`

- **Обновить запись о игре. Параметры: name, developer, genreIds[] (POST)**:
  `http://apricode.test/web/game/update/ID_Игры`

- **Удалить игру игру по id (POST)**:
  `http://apricode.test/web/game/delete/ID_Игры`

- **Поиск игр по id жанра (GET)**:
  `http://apricode.test/web/game/games-by-genre/ID_Жанра`

#### ЖАНРЫ

- **Получить все жанры (GET)**:
  `http://apricode.test/web/genre`

- **Получить один жанр по id (GET)**:
  `http://apricode.test/web/genre/view/ID_Жанра`

- **Создать жанр. Параметры: name (POST)**:
  `http://apricode.test/web/genre/create`

- **Обновить запись о жанре. Параметры: name (POST)**:
  `http://apricode.test/web/genre/update/ID_Жанра`

- **Удалить жанр по id_Жанра (POST)**:
  `http://apricode.test/web/genre/delete/ID_Жанра`
