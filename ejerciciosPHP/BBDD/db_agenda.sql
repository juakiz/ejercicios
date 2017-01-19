DROP DATABASE IF EXISTS db_agenda;
CREATE DATABASE db_agenda;
USE db_agenda;

CREATE TABLE t_contactos (
    nombre VARCHAR(20) NOT NULL,
	telefono VARCHAR(9) NOT NULL,
	PRIMARY KEY (nombre)
);

INSERT INTO t_contactos (nombre, telefono) VALUES ('Luisa', 547813477);
INSERT INTO t_contactos (nombre, telefono) VALUES ('Antonio', 628447631);
INSERT INTO t_contactos (nombre, telefono) VALUES ('Ana', 873652114);
INSERT INTO t_contactos (nombre, telefono) VALUES ('Jose', 784589647);
INSERT INTO t_contactos (nombre, telefono) VALUES ('Daniel', 678147994);
SELECT * FROM t_contactos ORDER BY nombre;