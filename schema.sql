create database assistlist;
use assistlist; 

create table user (
	id int not null auto_increment primary key,
	username varchar(50) not null,
	name varchar(50) not null,
	lastname varchar(50) not null,
	email varchar(255) not null,
	password varchar(60) not null,
	is_active boolean not null default 1,
	is_admin boolean not null default 0,
	created_at datetime
);

insert into user (username,password,is_admin,created_at) value ("admin",sha1(md5("admin")),1,NOW());


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


