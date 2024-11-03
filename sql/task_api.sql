create database task_api;
use task_api;

create table users (
    id int primary key auto_increment,
    name varchar(50) not null unique,
    email varchar(100) not null unique,
    password varchar(255) not null,
    created_at timestamp default current_timestamp
);

create table tasks (
    id int primary key auto_increment,
    user_id int not null,
    title varchar(255) not null,
    description text,
    status enum('pendente', 'em_progresso', 'concluida') default 'pendente',
    priority enum('baixa', 'media', 'alta') default 'media',
    due_date date,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    foreign key (user_id)
        references users (id)
        on delete cascade
);
