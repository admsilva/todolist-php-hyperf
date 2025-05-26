# API de uma aplicação de lista de tarefas

## Componentes

- PHP (8.4)
- MONGO (latest)
- MYSQL (latest)
- REDIS (latest)
- HYPERF (3.2)

## Instalação

1. Obtenha o projeto

``` 
   git clone git@github.com:admsilva/todolist-php-hyperf.git
   cd todolist-php-hyperf
   cp .env-example .env
   docker-compose up -d --build
```

2. Se quiser você pode alterar as variáveis de ambiente no arquivo .env:

``` 
APP_ENV=dev
UID=1000
USER_NAME=www
GID=1000
GROUP_NAME=www

APP_FOLDER=./src
LOG_FOLDER=./log
DOCKER_FILE_FOLDER=./docker

MYSQL_ROOT_PASSWORD=secret
MYSQL_DATABASE=todo
MYSQL_USER=user
MYSQL_PASSWORD=secret
MYSQL_SERVICE_TAGS=dev
MYSQL_SERVICE_NAME=mysql
MYSQL_PORT=3310

REDIS_PORT=6310
REDIS_PASSWORD=secret

MONGO_USER=user
MONGO_ROOT_PASSWORD=secret
MONGO_DATABASE=todo
MONGO_PORT=27010

APP_PORT=9510
```

## COMANDOS

* Rodar composer install no projeto
```
   docker-compose run --rm app.dev composer install
```

* Rodar composer update no projeto
```
   docker-compose run --rm app.dev composer update
```

## RECURSOS

### Mongo

```
   Host: localhost
   Port: 27010
   User: user
   Password: secret
```

### MySQL

```
   Host: localhost
   Port: 3310
   User: user
   Password: secret
```

### Redis

```
   Host: localhost
   Port: 6310
   Password: secret
```

## API



#### DOCKER DICAS

* Parar todos os containers
```sh
  docker kill $(docker ps -q)
```

* Remover todos os containers
```sh
  docker rm $(docker ps -a -q)
```

* Remover todas as imagens
```sh
  docker rmi $(docker images -q)
```