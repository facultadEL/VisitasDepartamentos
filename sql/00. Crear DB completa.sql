create table rol
{
	id serial not null primary key,
	nombre character varying not null,
	descripcion character varying
};

INSERT INTO rol(id,nombre,descripcion) VALUES(1,'Admin','Administrador del sistema');
INSERT INTO rol(id,nombre,descripcion) VALUES(2,'Depto','Departamentos de las distintas carreras');

create table usuario
{
	id serial not null primary key,
	user character varying not null,
	password character varying not null,
	rol_fk integer references rol(id),
	descripcion character varying not null,
	habilitado boolean not null default false
};

INSERT INTO usuario(user,password,rol_fk,descripcion,habilitado) VALUES('extension','extension2015',1,'Administrador del sistema',true);
INSERT INTO usuario(user,password,rol_fk,descripcion,habilitado) VALUES('deptoSistemas','deptoSistemas',2,'Departamento de Sistemas',true);
INSERT INTO usuario(user,password,rol_fk,descripcion,habilitado) VALUES('deptoQuimica','deptoQuimica',2,'Departamento de Quimica',true);
INSERT INTO usuario(user,password,rol_fk,descripcion,habilitado) VALUES('deptoElectronica','deptoElectronica',2,'Departamento de Electronica',true);
INSERT INTO usuario(user,password,rol_fk,descripcion,habilitado) VALUES('deptoMecanica','deptoMecanica',2,'Departamento de Mecanica',true);
INSERT INTO usuario(user,password,rol_fk,descripcion,habilitado) VALUES('deptoRural','deptoRural',2,'Departamento de Rural',true);

create table visita
{
	id serial not null primary key,
	nombre character varying not null,
	fecha date not null,
	anio integer not null,
	localidad integer references localidad(id) not null,
	solicitante integer references usuario(id) not null,
};

create table tipotelefono
{
	id serial not null primary key,
	nombre character varying not null,
	descripcion character varying
}

create table tipodni
{
	id serial not null primary key,
	nombre character varying not null,
	descripcion character varying
}

INSERT INTO tipodni(id,nombre,descripcion) VALUES(1,'DNI','Documento Nacional de Identidad');
INSERT INTO tipodni(id,nombre,descripcion) VALUES(2,'LC','Libreta Cívica');
INSERT INTO tipodni(id,nombre,descripcion) VALUES(3,'LE','Libreta de Enrolamiento');

create table alumno
{
	id serial not null primary key,
	nombre character varying not null,
	apellido character varying not null,
	tipodni integer references tipodni(id) not null,
	dni character varying not null,
	fecha_nac date,
	mail character varying,
}

create table telefono
{
	id serial not null primary key,
	caracteristica character varying not null,
	numero character varying not null,
	tipotelefono integer references tipotelefono(id),
	alumno integer references alumno(id)
}

create table alumnoxvisita
{
	id serial not null primary key,
	alumno integer references alumno(id),
	visita integer references visita(id)
}