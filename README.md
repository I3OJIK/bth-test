# Тестовое задание

## Setup

### Клонирование проекта:
```bash
git clone https://github.com/I3OJIK/bth-test.git bthtest  
cd bthtest
```
### Разворачивание проекта:

Если порт 3008 свободен запускаем команду:
```bash
make setup
```
Если нужно изменить порт:
```bash
# Добавляем в .env.example DB_EXTERNAL_PORT и после этого 
make setup
```

После успешного разворачивания проект доступен по ссылк - http://localhost:3007