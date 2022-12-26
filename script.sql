create table users
(
    id       int(255) auto_increment
        primary key,
    name     varchar(255) not null,
    login    varchar(255) not null,
    email    varchar(255) not null,
    password varchar(255) not null,
    avatar   varchar(255) null,
    constraint email_unic
        unique (email),
    constraint login_unic
        unique (login)
);

create table shorts
(
    id                 int auto_increment
        primary key,
    user_id_shorts     int          not null,
    description_shorts varchar(255) not null,
    coin_amount_shorts double       not null,
    coin_symbol_shorts varchar(255) not null,
    coin_price_shorts  double       not null,
    date_shorts        varchar(255) not null,
    sum_of_shorts      varchar(255) not null,
    constraint shorts_users_id_fk
        foreign key (user_id_shorts) references users (id)
);

create table users_crypto_profiles
(
    id          int(255) auto_increment,
    user_id     int(255)     not null,
    coin_symbol varchar(255) null,
    coin_amount varchar(255) null,
    coin_price  varchar(255) null,
    date        varchar(255) null,
    money_bag   varchar(255) null,
    description varchar(255) null,
    transaction varchar(255) null,
    constraint aaaa
        unique (id),
    constraint users_crypto_profiles_ibfk_1
        foreign key (user_id) references users (id)
)
    comment 'connection';

create index user_id
    on users_crypto_profiles (user_id);


