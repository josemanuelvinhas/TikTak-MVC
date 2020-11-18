# TikTak-MVC

Aplicación web que implementa una red social de vídeos cortos para la materia de TSW (Tecnologías y Servicios Web). Básicamente, la aplicación web deberá permitir la subida de vídeos, con una breve descripción (que puede incluir hashtags) y visualizar videos de los usuarios seguidos (muro) o de un hashtag cualquiera (búsqueda).

Características

1. Lógica de negocio, lógica de acceso a datos y generación de HTML separada: se hace uso del patrón MVC y de Data Mappers
2. Se hace uso de plantillas de página, que permiten modificar/eliminar/mover elementos comunes, como encabezados, pies, etc.
3. Permite la traducción sencilla de la interfaz a otros idiomas (internacionalización).
4. Todas las peticiones pasan por un punto de entrada común
5. Se sigue el patrón PRG (Post-Redirect-Get)
6. La interfaz de usuario es responsive. Se usa Bootstrap 4
