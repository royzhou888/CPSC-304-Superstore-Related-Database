Drop table Order_place;
Drop table Customer CASCADE CONSTRAINTS
drop TABLE EMPLOYEE CASCADE CONSTRAINTS
Drop table Manager CASCADE CONSTRAINTS
Drop table SUPPLIER CASCADE CONSTRAINTS
Drop table Inventory CASCADE CONSTRAINTS;
DROP SEQUENCE seq_order_num
DROP SEQUENCE seq_order

CREATE TABLE Inventory(
  quantity NUMBER(5),
  part NUMBER(5),
  name VARCHAR(20),
  price NUMBER(5),
  supplier VARCHAR(20),
  PRIMARY KEY(part)
);

CREATE TABLE Manager(
name VARCHAR(20),
sin NUMBER(10),
position VARCHAR(20),
rating NUMBER(2),
PRIMARY KEY (sin));

CREATE TABLE Employee(
name VARCHAR(20),
sin NUMBER(10) NOT NULL ,
position VARCHAR(20),
rating NUMBER(2),
manager_sin NUMBER(10),
PRIMARY KEY(sin),
FOREIGN KEY (manager_sin)REFERENCES Manager(sin));


CREATE TABLE supplier(
name VARCHAR(20),
address VARCHAR(50),
phone NUMBER(12),
status VARCHAR(2),
PRIMARY KEY (phone));


CREATE TABLE Customer(
name VARCHAR(20),
address VARCHAR(50),
phone NUMBER(10) NOT NULL,
points NUMBER(5),
PRIMARY KEY(phone));


CREATE TABLE Order_place(
sequence_Order NUMBER(10) NOT NULL,
order_num NUMBER(10) NOT NULL,
part_num NUMBER(5),
number_of_item NUMBER(5),
customer_phone_num NUMBER(10),
employee_sin_num NUMBER(10),
DateOfOrder DATE default CURRENT_TIMESTAMP,
PRIMARY KEY(sequence_Order),
FOREIGN KEY(customer_phone_num) REFERENCES Customer(phone),
FOREIGN KEY(employee_sin_num) REFERENCES Employee(sin),
FOREIGN KEY(part_num) REFERENCES INVENTORY(part));

CREATE SEQUENCE seq_order_num
  MINVALUE 1
  START WITH 1
  INCREMENT BY 1
  CACHE 10;

CREATE SEQUENCE seq_order
  MINVALUE 1
  START WITH 1
  INCREMENT BY 1
  CACHE 10;

insert into Manager values ('roy',123 ,'manager',6);
insert into Employee values ('roy',123 ,'manager',6,NULL);
insert into supplier values ('roy','ubc' ,'222222','t');
insert into Inventory values (10,98765 ,'Coke',6,'C_factory');
insert into Inventory values (10,98764 ,'Fiji Water',3,'C_factory');
insert into Customer values ('John','221B Baker Street' ,'666666',3);