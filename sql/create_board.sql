create table board(
    id int not null auto_increment,
    name varchar(140),
    about_text varchar(3000),
    icon_number int,
    user_name varchar(140),
    password varchar(32),
    create_time datetime,
    update_time datetime,
    primary key(id) 
);
