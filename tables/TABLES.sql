create table chair_measurements
(
    id int primary key,
    HR int,
    TIME timestamp,
    MAC varchar (20),
    HOST varchar (15),
    TYPE varchar (10),
    id_user int
);

create table bathtub_measurements
(
    id int primary key,
    Person_in bool,
    TEMP int,
    HR int,
    TIME timestamp,
    MAC varchar(20),
    HOST varchar(15),
    TYPE varchar(10)
);

CREATE TABLE patient
(
    id int primary key,
    name varchar(30) not null,
    surname varchar (50) not null,
    email varchar (50),
    phone_number varchar (10)
);

