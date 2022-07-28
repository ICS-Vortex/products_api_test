Installation
=========================

1. Build and run all needed docker containers:

```angular2html
docker-compose up -d --build
```

2. After all containers are up and running, enter php-container:

```angular2html
docker exec -it php-container bash
```

3. Inside Bash terminal of PHP Container install project:

```angular2html
composer install
```

4. Create database:

```angular2html
symfony console d:d:create
```

5. Run migrations:

```angular2html
symfony console d:m:migrate --no-interaction
```

6. Open URL `localhost:8080/api` in browser to play with API

Console Commands
================

1. Import categories from categories.json file first:

```angular2html
symfony console category:import 
```

2. Import products from products.json file:

```angular2html
symfony console product:import 
```
