/* SCRIPT QUE RESETEA LA BBDD BORRÁNDOLA (TODAS SUS TABLAS) SI EXISTE;
PARA LUEGO CREAR LAS TABLAS DESDE CERO Y AÑADIRLES REGISTROS */

DROP DATABASE IF EXISTS db_notas_varias_asignaturas;
CREATE DATABASE db_notas_varias_asignaturas;
USE db_notas_varias_asignaturas;

CREATE TABLE t_usuarios (
	usuario VARCHAR(10) NOT NULL,
	clave VARCHAR(10) NOT NULL,
	tipo enum('Profesor', 'Alumno'),
	PRIMARY KEY (usuario)
);

CREATE TABLE t_asignaturas (
	asignatura VARCHAR(10) NOT NULL,
	profesor VARCHAR(10) NOT NULL,
	PRIMARY KEY (asignatura),
	FOREIGN KEY (profesor) REFERENCES t_usuarios(usuario)  /*  obliga a insertar solo nombres de profesores que sean usuarios existentes en t_usuarios */
						 ON DELETE CASCADE  /* si se borra un usuario de t_usuario se borran sus asignaturas como profesor */
						 ON UPDATE CASCADE  /* si se actualiza el nombre de un usuario de t_usuario se actualiza su nombre como profesor */
);

CREATE TABLE t_notas (   
	alumno VARCHAR(10) NOT NULL,   /* es el campo usuario de la tabla t_usuarios */
	asignatura VARCHAR(10) NOT NULL,   /* es el campo asignatura de la tabla t_asignaturas */
	nota INT(2) UNSIGNED,
	PRIMARY KEY (alumno, asignatura),
	FOREIGN KEY (alumno) REFERENCES t_usuarios(usuario)  /*  obliga a insertar solo nombres de alumno que sean usuarios existentes en t_usuarios */
						 ON DELETE CASCADE  /* si se borra un usuario de t_usuarios se borran sus notas como alumno */
						 ON UPDATE CASCADE,  /* si se actualiza el nombre de un usuario de t_usuarios se actualiza su nombre como alumno */
	FOREIGN KEY (asignatura) REFERENCES t_asignaturas(asignatura)  /*  obliga a insertar solo nombres de asignaturas que existentan en t_asignaturas */
						 ON DELETE CASCADE  /* si se borra una asignatura en t_asignaturas se borran sus notas como alumno */
						 ON UPDATE CASCADE  /* si se actualiza el nombre de una asignatura de t_asignaturas se actualiza su nombre como asignatura */						 
);

INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('manuel', 'manuel', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('luisa', 'luisa', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('antonio', 'antonio', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('ana', 'ana', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('jose', 'jose', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('daniel', 'daniel', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('carlos', 'carlos', 'Alumno');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('pro', 'pro', 'Profesor');
INSERT INTO t_usuarios (usuario, clave, tipo) VALUES ('fol', 'fol', 'Profesor');

SELECT * FROM t_usuarios ORDER BY usuario;

INSERT INTO t_asignaturas (profesor, asignatura) VALUES ('pro','DPL');
INSERT INTO t_asignaturas (profesor, asignatura) VALUES ('pro','DSW');
INSERT INTO t_asignaturas (profesor, asignatura) VALUES ('fol','FOL');

SELECT * FROM t_asignaturas ORDER BY asignatura;

INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('manuel', 'DPL', 5);
INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('manuel', 'DSW', 6);
INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('manuel', 'FOL', 8);

INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('luisa', 'DPL', 7);

INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('antonio', 'DPL', 8);
INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('antonio', 'DSW', 5);

INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('ana', 'DSW', 4);

INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('jose', 'FOL', 6);

INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('daniel', 'DSW', 3);
INSERT INTO t_notas (alumno, asignatura, nota) VALUES ('daniel', 'DPL', 5);

SELECT * FROM t_notas ORDER BY alumno;


