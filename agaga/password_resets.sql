create table agaga.password_resets
(
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null
);

create index password_resets_email_index
    on agaga.password_resets (email);

