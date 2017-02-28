create table message(
    id int not null auto_increment,
    board_id int,
    message varchar(3000),
    user_id varchar(20),
    user_name varchar(140),
    icon_number int,
    create_time datetime,
    update_time datetime,
    primary key(id, board_id)
);
