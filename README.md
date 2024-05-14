<p align="center"><a href="https://symfony.com" target="_blank"><img src="https://symfony.com/logos/symfony_black_03.svg" width="400" alt="Symfony Logo"></a></p>

# Spalopia


## Tabla de Contenidos

1. [Requisitos](#requisitos)
2. [Instalación](#instalación)
3. [Uso](#uso)
4. [Tests](#tests)

## Requisitos
- PHP 8.1 (requerido por laravel 10) y sus dependencias con:
   ```
   sudo apt-get update
   sudo apt-get install php8.1
   sudo apt-get install php8.1-xml
   sudo apt-get install php8.1-curl
   sudo apt-get install php8.1-mysql
   sudo apt-get install php8.1-mbstring
   ```
- Composer con: [Link de instalación](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04)
- MySql con: `sudo apt install mysql-server`
- Symfony CLI con: [Link de instalación](#https://symfony.com/download)

## Instalación
1. Clona el repositorio:
```bash
   git clone https://github.com/QuerenPacheco/Spalopia
```

2. Instala las dependencias utilizando Composer:
```bash
    cd tu-proyecto
    composer install
```
3. Actualiza la base de datos:
```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
```
4. Inicia el servidor local
```bash
    symfony serve:start
```
5. Si visitamos http://localhost:8000 en el navegador veremos la aplicación.

## Uso

Rutas:
- Listado de servicios: /servicios - Aquí nos muestra un listado de todos los servicios existentes.

- Listado de horas disponibles de un servicio: /listado-horas-disponibles/{nombre del servicio}/{fecha del servicio} - Dados un nombre de servicio y una fecha nos indicará las horas que queden disponibles si las hubiera. Ejemplo de ruta: http://localhost:8000/listado-horas-disponibles/masaje%20facial/2024-05-01

- Crear reservas: /reserva - Muestra un formulario en el que rellenaremos los datos para crear una reserva. Cuando seleccionamos la fecha y el tipo de servicio que queremos nos mostrará las horas disponibles (si las hubiera) y el precio del servicio.

## Tests

Para ejecutar los tests: 
`php bin/phpunit`
