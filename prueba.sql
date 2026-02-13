create database prueba3Abm;
use prueba3Abm;

create table roles(
rol tinyint primary key,
descripcion varchar(20));

insert into roles values (1, "administrador"), (2, "profesor");

select * from roles;

create table usuarios(
id_user int auto_increment primary key,
user varchar (20),
pass varchar (10),
nombre varchar (20),
apellido varchar (25),
rol tinyint,
foreign key(rol) references roles(rol));

insert into usuarios values(null, "Profe", "prof123", "Juan", "Perez", 2),
(null, "Admin", "admin123", "Administrador", "Adminis", 1);

select * from usuarios;


create table alumnos(
id_alumno bigint unsigned not null primary key auto_increment,
nombre varchar(20),
apellido varchar(20),
dni int,
domicilio varchar(60),
telefono varchar(20));

insert into alumnos values(null, "Ana", "Lopez", 45678901, "Laprida 345", "115678-2314"),
(null, "Maria", "Suarez", 23456783, "Lacarra 34", "114455-3467"),
(null, "Laura", "Mirra", 34563215, "Belgrano 56", "114478-9876"),
(null, "Juan", "Diaz", 20345673, "Laprida 345", "115678-2314");

SELECT * FROM alumnos;
SELECT id_alumno, nombre, apellido FROM alumnos;

create table materias(
cod_mat bigint unsigned not null primary key auto_increment,
materia varchar(20),
nombreCompl_prof varchar(30));

insert into materias values (null, "Sociales", "Estevez, Maria Rosa"),
(null, "Matematica", "Sonia Lopez"),
(null, "Matematica", "Sonia Lopez"),
(null, "Matematica", "Sonia Lopez");

SELECT * FROM materias;

create table notas(
id_notas bigint unsigned not null primary key auto_increment,
id_alumno bigint unsigned not null,
cod_mat bigint unsigned not null,
nota1 decimal(9,2) not null,
nota2 decimal(9,2) not null,
notafinal decimal(9,2) not null,
foreign key (cod_mat) references materias(cod_mat) on delete cascade on update cascade,
foreign key (id_alumno) references alumnos(id_alumno) on delete cascade on update cascade);

INSERT INTO notas values (null, 2, 4, 7.6, 8, 8);
INSERT INTO notas values (null, 2, 3, 7, 9, 8);

SELECT * FROM notas;

SELECT alumnos.id_alumno AS id_alumnoALUMNOS, 
 alumnos.nombre AS nombreALUMNOS, alumnos.apellido AS apellidoALUMNOS,
notas.cod_mat AS cod_matNOTAS, notas.nota1 AS nota1NOTAS, notas.nota2 AS nota2NOTAS, 
notas.notafinal AS notafinalNOTAS    
     FROM alumnos
		
     RIGHT JOIN notas ON notas.id_alumno = alumnos.id_alumno WHERE notas.cod_mat = 3;
     
     /*WHERE cod_mat = 2;*/




