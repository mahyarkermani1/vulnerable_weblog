create table users (
    user_id int auto_increment primary key,
    username varchar(255) not null,
    email varchar(255) not null,
    first_name varchar(255) default null,
    last_name varchar(255) default null,
    bio varchar(1000) default null,
    password varchar(255) not null,
    registration_date timestamp default current_timestamp,
    unique (username, email)
);