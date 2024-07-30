create database Medical_DB;

use Medical_DB ;



create table cities (
id  int auto_increment,
city_name varchar(20) , 
created_at timestamp   default now() ,
admin_id int ,
primary key(id) , 
foreign key (admin_id) references admins(id) on delete cascade on update cascade
);

create table pharmaceutical (
id int auto_increment ,
name varchar(25),
created_at timestamp default now(),
city_id int , 
price float ,
quantity bigint,
primary key(id),
foreign key(city_id) references cities(id) on delete cascade on update cascade
);

create table orders(
id int auto_increment , 
order_name varchar(25) , 
order_mobile bigint unique , 
order_email varchar(25) , 
order_notes text , 
pharmaceutical_id int ,
city_id int ,
created_at timestamp default now(),
primary key(id),
foreign key(pharmaceutical_id) references pharmaceutical(id) on delete cascade on update cascade ,
foreign key(city_id) references cities(id) on delete cascade on update cascade
);

create table admins (
id int auto_increment, 
admin_name varchar(25) , 
admin_email varchar(25) unique, 
admin_password varchar(100),
admin_type enum('admin' ,'super_admin') default  'admin' ,
created_at timestamp default now() , 
salary float ,
primary key (id)
);





