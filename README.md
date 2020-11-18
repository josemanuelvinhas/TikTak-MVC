# TikTak-MVC

Aplicación web que implementa una red social de vídeos cortos para la materia de TSW (Tecnologías y Servicios Web). Básicamente, la aplicación web deberá permitir la subida de vídeos, con una breve descripción (que puede incluir hashtags) y visualizar videos de los usuarios seguidos (muro) o de un hashtag cualquiera (búsqueda).

### Características :clipboard:

1. Lógica de negocio, acceso a datos y generación de HTML separada: se hace uso del patrón MVC y de Data Mappers
2. Se hace uso de plantillas de página, que permiten modificar/eliminar/mover elementos comunes
3. Permite la traducción sencilla de la interfaz a otros idiomas (internacionalización).
4. Todas las peticiones pasan por un punto de entrada común
5. Se sigue el patrón PRG (Post-Redirect-Get)
6. La interfaz de usuario es responsive

### Instalación :wrench:

El proyecto se ha desarrollado en [XAMPP](https://www.apachefriends.org/) :

  + Apache 2.4.46
  + MariaDB 10.4.14
  + PHP 7.4.11 (VC15 X86 64bit thread safe) + PEAR
  + phpMyAdmin 5.0.3

Pasos para probar la aplicación:

1. Instalar XAMPP
2. Iniciar servidor Apache y MySQL
3. Clonar el repositorio en la carpeta `xampp/htdocs/` (se puede hacer uso de _git clone_)
4. Crear la base de datos usando el script `bd_tiktak.sql` (se puede hacer uso de la herramienta gráfica _phpMyAdmin_)

## Construido con :hammer_and_wrench:

* [PhpStorm](https://www.jetbrains.com/es-es/phpstorm/)
* [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/)

## Autores :black_nib:

* **José Manuel Viñas Cid** -  [josemanuelvinhas](https://github.com/josemanuelvinhas)
* **Yomar Costa Orellana** - [Yomiquesh](https://github.com/Yomiquesh)

