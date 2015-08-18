create table rol
(
	id serial not null primary key,
	nombre character varying not null,
	descripcion character varying
);

INSERT INTO rol(id,nombre,descripcion) VALUES(1,'Admin','Administrador del sistema');
INSERT INTO rol(id,nombre,descripcion) VALUES(2,'Depto','Departamentos de las distintas carreras');

create table usuario
(
	id serial not null primary key,
	username character varying not null,
	pass character varying not null,
	rol_fk integer references rol(id),
	descripcion character varying not null,
	habilitado boolean not null default false,
	primera_vez boolean not null default true
);

INSERT INTO usuario(username,pass,rol_fk,descripcion,habilitado,primera_vez) VALUES('extension','450bf955269344086561b636f00b7041',1,'Administrador del sistema',true,false);
INSERT INTO usuario(username,pass,rol_fk,descripcion,habilitado,primera_vez) VALUES('deptoSistemas','b6b23d2072cb5d36ae11b3c0a2c7e75e',2,'Departamento de Sistemas',true,true);
INSERT INTO usuario(username,pass,rol_fk,descripcion,habilitado,primera_vez) VALUES('deptoQuimica','eed7e9fc280e4b2f4604891a7546437b',2,'Departamento de Quimica',true,true);
INSERT INTO usuario(username,pass,rol_fk,descripcion,habilitado,primera_vez) VALUES('deptoElectronica','798d5da96dbff3888d84cdef41577703',2,'Departamento de Electronica',true,true);
INSERT INTO usuario(username,pass,rol_fk,descripcion,habilitado,primera_vez) VALUES('deptoMecanica','edb9088d30a15298598dfa97033b753d',2,'Departamento de Mecanica',true,true);
INSERT INTO usuario(username,pass,rol_fk,descripcion,habilitado,primera_vez) VALUES('deptoRural','7c7f82d0ff102b418cf462c20ea1f60a',2,'Departamento de Rural',true,true);

create table visita
(
	id serial not null primary key,
	nombre character varying not null,
	catedra character varying not null,
	profesor_catedra character varying not null,
	profesor_visita character varying,
	movilidad character varying not null,
	fecha date not null,
	nombre_empresa character varying not null,
	area_empresa character varying,
	nombre_contacto character varying not null,
	apellido_contacto character varying not null,
	cargo_contacto character varying,
	mail_contacto character varying,
	telefono_empresa character varying,
	motivo_visita text not null,
	solicitante_fk integer references usuario(id) not null
);

create table tipotelefono
(
	id serial not null primary key,
	nombre character varying not null,
	descripcion character varying
);

create table tipodni
(
	id serial not null primary key,
	nombre character varying not null,
	descripcion character varying
);

INSERT INTO tipodni(id,nombre,descripcion) VALUES(1,'DNI','Documento Nacional de Identidad');
INSERT INTO tipodni(id,nombre,descripcion) VALUES(2,'LC','Libreta Cívica');
INSERT INTO tipodni(id,nombre,descripcion) VALUES(3,'LE','Libreta de Enrolamiento');

create table alumno
(
	id serial not null primary key,
	nombre character varying not null,
	apellido character varying not null,
	tipodni_fk integer references tipodni(id) not null,
	dni character varying not null,
	fecha_nac date,
	mail character varying
);

create table telefono
(
	id serial not null primary key,
	caracteristica character varying not null,
	numero character varying not null,
	tipotelefono_fk integer references tipotelefono(id),
	alumno_fk integer references alumno(id)
);

create table alumnoxvisita
(
	id serial not null primary key,
	alumno_fk integer references alumno(id),
	visita_fk integer references visita(id)
);