create table users
(
    id int auto_increment
        primary key,
    ip bigint not null,
    constraint users_ip_uindex
        unique (ip)
);

create table words
(
    id      int auto_increment
        primary key,
    word    varchar(255) not null,
    count   int          not null,
    user_id int          not null,
    constraint words_users_id_fk
        foreign key (user_id) references users (id)
);