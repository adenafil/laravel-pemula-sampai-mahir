create database belajar_laravel_database;

use belajar_laravel_database;

create table cetagories
(
    id varchar(100) not null primary key ,
    name varchar(100) not null ,
    description text,
    created_at timestamp
) engine  = innodb;

desc cetagories;
