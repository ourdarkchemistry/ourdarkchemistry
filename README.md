# REST API для управления пользователями

Этот проект реализует REST API для управления пользователями с использованием Symfony.

## Методы API

### Создание пользователя

**POST /users**

- **Параметры**: 
  - `username` (string)
  - `password` (string)
  - `email` (string)
  
- **Ответ**: 
  - `201 Created` с данными пользователя.

### Обновление информации пользователя

**PUT /users/{id}**

- **Параметры**:
  - `username` (string)
  - `email` (string)
  
- **Ответ**:
  - `200 OK` с обновленными данными пользователя.

### Удаление пользователя

**DELETE /users/{id}**

- **Ответ**:
  - `204 No Content`.

### Авторизация пользователя

**POST /login**

- **Параметры**:
  - `username` (string)
  - `password` (string)

- **Ответ**:
  - `200 OK` с токеном или `401 Unauthorized`.

### Получить информацию о пользователе

**GET /users/{id}**

- **Ответ**:
  - `200 OK` с данными пользователя.

