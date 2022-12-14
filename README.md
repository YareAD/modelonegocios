## Proyecto final

Proyecto final para la materia de Desarrollo web 2

## instalación

1.- Copiar variables de entorno

```
cp .env.example .env
```

2.- si usa docker usar

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer update laravel/sail
```

```
./vendor/bin/sail up -d
```

si no simplemente

```
composer install 
npm i
php artisan key:generate
php artisan migrate
php artisan serve
npm run dev
```#   m o d e l o n e g o c i o s  
 