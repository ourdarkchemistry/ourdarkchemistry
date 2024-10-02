# REST API для работы с пользователями
## Методы API
### 1. Создание пользователя
- **URL**: `/users`
- **Метод**: `POST`
- **Тело запроса**:
  ```json
  {
      "email": "user@example.com",
      "password": "securepassword"
  }
