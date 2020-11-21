# TikTak-MVC

Aplicación web que implementa una red social de vídeos cortos para la materia de TSW (Tecnologías y Servicios Web). Básicamente, la aplicación web deberá permitir la subida de vídeos, con una breve descripción (que puede incluir hashtags) y visualizar videos de los usuarios seguidos (muro) o de un hashtag cualquiera (búsqueda).

#### Versión alternativa :link:

+ [TikTak-SPA](https://github.com/josemanuelvinhas/TikTak-SPA)

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
4. Crear la base de datos usando el script `bd_tiktak.sql` (este archivo ya incluye la creación del usuario de la base de datos). Se puede hacer uso de la herramienta gráfica _phpMyAdmin_
    + Script de creación de la base de datos
     ```
        DROP DATABASE IF EXISTS TIKTAK;
        
        CREATE DATABASE TIKTAK CHARACTER SET utf8mb4;
        
        USE TIKTAK;
        
        CREATE OR REPLACE TABLE USERS(
            username VARCHAR(15),
            email VARCHAR(320) NOT NULL UNIQUE,
            passwd VARCHAR(20) NOT NULL,
            nfollowers INT unsigned NOT NULL DEFAULT 0,
        	nfollowing INT unsigned NOT NULL DEFAULT 0,
            PRIMARY KEY (username)
        ) ENGINE = INNODB DEFAULT CHARACTER SET = utf8;
        
        CREATE OR REPLACE TABLE VIDEOS(
            id INT unsigned auto_increment,
            videoname VARCHAR(30) NOT NULL,
            videodescription VARCHAR(320) NOT NULL,
            videodate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            author VARCHAR(15) NOT NULL,
            nlikes INT unsigned NOT NULL DEFAULT 0,
            PRIMARY KEY (id),
            FOREIGN KEY (author) REFERENCES USERS(username) ON DELETE CASCADE
        ) ENGINE = INNODB DEFAULT CHARACTER SET = utf8;
        
        CREATE OR REPLACE TABLE HASHTAGS(
            id INT unsigned,
            hashtag VARCHAR(320) NOT NULL,
            PRIMARY KEY (id, hashtag),
            FOREIGN KEY (id) REFERENCES VIDEOS(id) ON DELETE CASCADE
        )ENGINE = INNODB DEFAULT CHARACTER SET = utf8;
        
        CREATE OR REPLACE TABLE LIKES(
            username VARCHAR(15),
            id INT unsigned,
            PRIMARY KEY (username, id),
            FOREIGN KEY (username) REFERENCES USERS(username) ON DELETE CASCADE,
            FOREIGN KEY (id) REFERENCES VIDEOS(id) ON DELETE CASCADE
        ) ENGINE = INNODB DEFAULT CHARACTER SET = utf8;
        
        CREATE OR REPLACE TABLE FOLLOWERS(
            username_follower VARCHAR(15),
            username_following VARCHAR(15),
            PRIMARY KEY (username_follower, username_following),
            FOREIGN KEY (username_follower) REFERENCES USERS(username) ON DELETE CASCADE,
            FOREIGN KEY (username_following) REFERENCES USERS(username) ON DELETE CASCADE
        ) ENGINE = INNODB DEFAULT CHARACTER SET = utf8;
        
        DELIMITER //
        CREATE OR REPLACE TRIGGER increase_likes
        AFTER INSERT ON LIKES
        FOR EACH ROW
        BEGIN
            DECLARE numlikes INT;
            SELECT COUNT(*) INTO numlikes FROM LIKES WHERE LIKES.id = NEW.id;
            UPDATE VIDEOS SET nlikes = numlikes WHERE VIDEOS.id = NEW.id;
        END//
        
        DELIMITER //
        CREATE OR REPLACE TRIGGER decrease_likes
        AFTER DELETE ON LIKES
        FOR EACH ROW
        BEGIN
            DECLARE numlikes INT;
            SELECT COUNT(*) INTO numlikes FROM LIKES WHERE LIKES.id = OLD.id;
            UPDATE VIDEOS SET nlikes = numlikes WHERE VIDEOS.id = OLD.id;
        END//
        
        DELIMITER //
        CREATE OR REPLACE TRIGGER increase_follower
        AFTER INSERT ON FOLLOWERS
        FOR EACH ROW
        BEGIN
            DECLARE numfollowers INT;
        	DECLARE numfollowings INT;
        
            SELECT COUNT(*) INTO numfollowers FROM FOLLOWERS WHERE FOLLOWERS.username_following = NEW.username_following;
            UPDATE USERS SET nfollowers = numfollowers WHERE USERS.username = NEW.username_following;
        
            SELECT COUNT(*) INTO numfollowings FROM FOLLOWERS WHERE FOLLOWERS.username_follower = NEW.username_follower;
            UPDATE USERS SET nfollowing = numfollowings WHERE USERS.username = NEW.username_follower;
        END//
        
        DELIMITER //
        CREATE OR REPLACE TRIGGER decrease_follower
        AFTER DELETE ON FOLLOWERS
        FOR EACH ROW
        BEGIN
            DECLARE numfollowers INT;
        	DECLARE numfollowings INT;
        
            SELECT COUNT(*) INTO numfollowers FROM FOLLOWERS WHERE FOLLOWERS.username_following = OLD.username_following;
            UPDATE USERS SET nfollowers = numfollowers WHERE USERS.username = OLD.username_following;
        
            SELECT COUNT(*) INTO numfollowings FROM FOLLOWERS WHERE FOLLOWERS.username_follower = OLD.username_follower;
            UPDATE USERS SET nfollowing = numfollowings WHERE USERS.username = OLD.username_follower;
        END//
   ```
   + Añadir el usuario de la base de datos
   ```
   grant all privileges on tiktak.* to mvcuser@localhost identified by "mvctiktakpass";
   ```

## Construido con :hammer_and_wrench:

* [mvcblog](https://github.com/lipido/mvcblog) - Framework MVC
* [PhpStorm](https://www.jetbrains.com/es-es/phpstorm/) - IDE
* [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/) - Framework front-end

## Autores :black_nib:

* **José Manuel Viñas Cid** -  [josemanuelvinhas](https://github.com/josemanuelvinhas)
* **Yomar Costa Orellana** - [Yomiquesh](https://github.com/Yomiquesh)

