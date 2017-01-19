/* SCRIPT QUE RESETEA LA BBDD BORRÁNDOLA (TODAS SUS TABLAS) SI EXISTE;
PARA LUEGO CREAR LAS TABLAS DESDE CERO Y AÑADIRLES REGISTROS */

DROP DATABASE IF EXISTS db_notas;
CREATE DATABASE db_notas;
USE db_notas;

CREATE TABLE t_usuarios (
	usuario VARCHAR(10) NOT NULL,
	clave VARCHAR(10) NOT NULL,
	tipo enum('Profesor', 'Alumno'),
	PRIMARY KEY (usuario)
);

CREATE TABLE t_notas (   
	alumno VARCHAR(10) NOT NULL,   /* es el campo usuario de la tabla t_usuarios */
	nota INT(2) UNSIGNED,
	PRIMARY KEY (alumno),
	FOREIGN KEY (alumno) REFERENCES t_usuarios(usuario)  /*  obliga a insertar solo nombres de alumno que sean usuarios existentes en t_usuarios */
						 ON DELETE CASCADE  /* si se borra un usuario de t_usuarios se borran sus notas como alumno */
						 ON UPDATE CASCADE  /* si se actualiza el nombre de un usuario de t_usuarios se actualiza su nombre como alumno */
);

INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('manuel', 'manuel', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('luisa', 'luisa', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('antonio', 'antonio', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('ana', 'ana', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('jose', 'jose', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('daniel', 'daniel', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('rosa', 'rosa', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('pro', 'pro', 'Profesor');

SELECT * FROM t_usuarios ORDER BY usuario;

INSERT INTO t_notas (alumno, nota) VALUES ('manuel', 5);
INSERT INTO t_notas (alumno, nota) VALUES ('luisa', 7);
INSERT INTO t_notas (alumno, nota) VALUES ('antonio', 8);
INSERT INTO t_notas (alumno, nota) VALUES ('ana', 4);
INSERT INTO t_notas (alumno, nota) VALUES ('jose', 6);
INSERT INTO t_notas (alumno, nota) VALUES ('daniel', 3);
INSERT INTO t_notas (alumno, nota) VALUES ('rosa', null);

SELECT * FROM t_notas ORDER BY alumno;