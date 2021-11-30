/* Создать базу данных с названием users */
CREATE DATABASE access;

/* Дальнейшие действия выполняются над базой данных users */
USE access;

/* Роли для разграничения доступа */
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name NVARCHAR(64) NOT NULL
);

INSERT INTO roles(name) VALUES ('Admin'), ('User');

/* Таблица для пользователей */
CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role_id INT UNSIGNED NOT NULL REFERENCES roles(id),
    login NVARCHAR(64) unique,
    sault BINARY(4),
    password_hash BINARY(64),
    data JSON NOT NULL
);

/* Заметки */
CREATE TABLE notes (
    user_id INT UNSIGNED,
    id BIGINT UNSIGNED AUTO_INCREMENT,
    body NVARCHAR(2048) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(user_id, id),
    KEY(id)
);


/* Создать пользователя с именем authentificator, который сможет заходить только с машины
   с именем localhost (или адресом localhost) с помощью пароля SomeFantasticPassword */
CREATE USER 'authentificator'@'localhost' IDENTIFIED BY 'SomeFantasticPassword';

/* Разрешить аутентификатору читать, вставлять и обновлять таблицу users */
GRANT SELECT ON access.* TO 'authentificator'@'localhost';
GRANT UPDATE ON access.* TO 'authentificator'@'localhost';
GRANT INSERT ON access.* TO 'authentificator'@'localhost';


