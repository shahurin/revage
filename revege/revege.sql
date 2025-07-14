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
    login varchar(100) not null unique,
    password varchar(100) not null
);


