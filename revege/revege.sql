drop database if exists revege;
create database revege default character set utf8 collate utf8_general_ci;
drop user if exists 'revege_staff'@'localhost';
create user 'revege_staff'@'localhost' identified by 'password';
grant all on revege.* to 'revege_staff'@'localhost';
use revege;



create table customer (
    id int auto_increment primary key,
    name varchar(200) not null,
    address varchar(200) not null,
    user_id varchar(100) not null unique,
    password varchar(100) not null
);

create table product (
    id int auto_increment primary key,
    name varchar(200) not null,
    detail varchar not null,
    price varchar not null,
    seller varchar not null,
);

create table recipe (
    id int auto_increment primary key,
    name varchar(200) not null,
    Poster varchar(200) not null,
);


insert into customer values(null,'清風太郎','大阪','SEIFU','SEIFU');





