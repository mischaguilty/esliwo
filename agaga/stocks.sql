create table agaga.stocks
(
    id         bigint unsigned auto_increment
        primary key,
    source_id  bigint unsigned not null,
    name       varchar(255)    not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint stocks_name_unique
        unique (name),
    constraint stocks_source_id_unique
        unique (source_id)
);

