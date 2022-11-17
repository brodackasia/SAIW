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
