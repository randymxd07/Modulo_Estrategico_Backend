<div style="justify-content: center">
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
</div>

## Clonar el repositorio

```SSH```
```
git@github.com:randymxd06/Modulo_Estrategico_Backend.git
```

```HTTPS```
```
https://github.com/randymxd06/Modulo_Estrategico_Backend.git
```

## Instalar las dependencias

```
composer install
```

## Actualizar las dependencias

```
composer update
```

## Variables de entorno y base de datos

Se debe de copiar y pegar el archivo ```.env.example``` y a la copia cambiarle el nombre a ```.env``` para luego editar las variables para el funcionamiento de la base de datos, para esto deitar las siguientes lineas del ```.env```:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

## Agregar la key del proyecto

```
php artisan key:generate
```

Adicionalmente debemos de crear un ```secret key``` para que el paquete de JWT funcione correctamente, para eso utilizamos el siguiente comando:

```
php artisan jwt:secret
```

Luego hay que verificar si la conexion con la base de datos esta buena para eso podemos probar un comando que genera una tabla llamada ```migrations``` la cual contiene todas las migraciones que hayamos hecho:

```
php artisan migrate:install
```

Si todo sale bien entonces podemos utilizar el comando para crear las tablas necesarias para el funcionamiento del proyecto.

```
php artisan migrate
```

## Agregar datos de prueba a la base de datos

```
php artisan db:seed
```

## Levantar el servidor

```
php artisan serve
```

## Borrar la cache

```
php artisan optimize
```

```
php artisan optimize:clear
```

```
composer clear cache
```
