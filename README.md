# Desafio técnico | Conexa

## Sobre el proyecto
Realicé este desafio usando Laravel Sail, el cual está sobre la versión 9 de Laravel y php 8.1.13. Por lo cual es importante contar con **Docker** (o **Docker Desktop + WSL habilitado** para el caso de windows) en la máquina local para levantar y testear el proyecto. Adicionalmente decidi usar el estándar **JWT** para el proceso de autenticación de la API Rest que vamos a exponer.(Se adjunta también una collection de la API hecha en [Thunder Client](https://www.thunderclient.com/)).

## Comenzando

Con el fin de simplificar un poco los comandos para inicializar el proyecto y trabajar sobre el, creé el alias **sail**, que estara presente en todos los comandos que se van a detallar a continuación. Este alias llama y hace referencia al binario de Laravel Sail (**.vendor/bin/sail**). Los siguientes procesos de configuración estan pensados para un entorno Windows, el mismo entorno con el que desarrollé el proyecto. [Aca](https://www.webune.com/forums/wepyap.html) se puede encontrar una guía de configuración para un entorno de Linux.  

## Configuraciones iniciales

Los siguientes comandos deberian ser ejecutados dentro de una sesión de terminal WSL. En mi caso use una distribución **Debian** para interactuar con el entorno de la aplicación.

Una vez clonado el repositorio en la máquina local, procedemos a realizar las siguientes configuraciones:

* Copiar el archivo .env.example a .env y editar preferencias (opcional ya que en mi caso utilice las configuraciones por defecto de Laravel Sail):

    ```cp .env.example .env```

* Instalar las dependencias del proyecto con composer:

    ```sail composer install```

* Generar la Key de la aplicación con el comando artisan:

    ``` sail artisan key:generate ```

* Generar la clave secreta para manejar el cifrado de los tokens JWT. Para trabajar con este estándar se hizo uso de la libreria [php-open-source-saver/jwt-auth](https://github.com/PHP-Open-Source-Saver/jwt-auth)

    `sail artisan jwt:secret`

## Base de datos

En este caso utilicé una BBDD Mysql tradicional para la persistencia de datos. Adicionalmente creé un usuario de prueba en los seeders de la aplicación para probar la API sin recurrir el endpoint de registro de usuario. Se pueden correr las migraciones con este comando:

    sail artisan migrate --seed

## Tests Funcionales

El proyecto cuenta con 2 test funcionales sencillos para comprobar el correcto funcionamiento de la API, los cuales incluyen una comprobación del estado del servicio, una prueba de registro de usuario y una petición autenticada hacia un recurso de la API enviada con ese mismo usuario generado en el test (algo asi como hacer un trámite en la ANSES).

    sail artisan test


##### Muchas gracias 
    





