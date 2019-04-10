/**
* Lb Admin
* @author evilnapsis
**/
create database assistlistmax;
use assistlistmax;



create table kind(
	id int not null auto_increment primary key,
	name varchar(50) not null
);

insert into kind (name) value ("Administrador");
insert into kind (name) value ("Usuario");


create table user(
	id int not null auto_increment primary key,
	bio text,
	image varchar(255),
	name varchar(50) not null,
	lastname varchar(50) not null,
	username varchar(50),
	email varchar(255) not null,
	password varchar(60) not null,
	phone varchar(255),
	address varchar(255),
	code varchar(20),
	status boolean not null default 0,
	kind boolean not null default 0,
	created_at datetime not null
);

insert into user(email,password,status,kind,created_at) value ("admin","90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad",1,1,NOW());


create table person(
	id int not null auto_increment primary key,
	image varchar(50) not null,
	name varchar(50) not null,
	lastname varchar(50) not null,
	email varchar(255) not null,
	address varchar(60) not null,
	phone varchar(60) not null,
	c1_fullname varchar(100),
	c1_address varchar(100),
	c1_phone varchar(100),
	c1_note varchar(100),
	c2_fullname varchar(100),
	c2_address varchar(100),
	c2_phone varchar(100),
	c2_note varchar(100),
	is_active boolean not null default 1,
	created_at datetime,
	user_id int not null,
	foreign key (user_id) references user(id)
);

/* 1.- Asistencia, 2.- Falta, 3.- Retardo, 4.- Justificacion */
create table assistance(
	id int not null auto_increment primary key,
	kind_id int,
	date_at date not null,
	person_id int not null,
	user_id int not null,
	foreign key (user_id) references user(id),
	foreign key (person_id) references person(id)
);


