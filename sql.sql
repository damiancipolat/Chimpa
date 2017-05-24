--CREAR TABLAS
create table album
(
	idalbum			int AUTO_INCREMENT,
	fec_creacion 	date,
	nombre			varchar(100),
	descripcion		varchar(500),
	PRIMARY KEY(idalbum)
);

create table fotos
(
	idfoto			int AUTO_INCREMENT,
	fec_creacion 	date,
	idalbum 		int,
	archivo			varchar(100),
	descripcion		varchar(500),
	nombre			varchar(100),
	PRIMARY KEY(idfoto)
);

create table usuarios
(
	idusuario		int AUTO_INCREMENT,
	fec_creacion 	date,
	usuario			varchar(100),
	password 		varchar(10),
	PRIMARY KEY(idusuario)
);

--Cargar usuario administrador.
insert into usuarios(fec_creacion,usuario,password) values(now(),'admin','admin');
