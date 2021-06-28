SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE QUEINV_DB;

USE QUEINV_DB;

CREATE TABLE Product(
  p_id int NOT NULL,
  file varchar(255) NOT NULL,
  product_SKU varchar(20) NOT NULL,
  reorder_points int NOT NULL,
  product_qty int NOT NULL,
  sold_qty int NOT NULL,
  waste_qty int NOT NULL,
  location varchar(40) NOT NULL,
  last_updated DATE not NULL,
  name varchar(30) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  DOPrice DECIMAL(10,2) NOT NULL,
  product_type ENUM('food', 'non-food'),
  entryStatus varchar (255) default 'ok',
  PRIMARY KEY (p_id),
  UNIQUE (name)
);

ALTER TABLE `Product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

CREATE TABLE CustomerDetails(
  customer_id int NOT NULL,
  first_name varchar(20) NOT NULL,
  mi varchar(2) NOT NULL,
  last_name varchar(20) NOT NULL,
  address varchar(40) NOT NULL,
  last_transacted DATETIME NOT NULL,
  entryStatus varchar (255) default 'ok',
  PRIMARY KEY (customer_id)
);

INSERT INTO CustomerDetails (first_name, mi, last_name, address, last_transacted)
VALUES ('stub', 'stub', 'stub', 'stub', '0000-00-00 00-00-00');

ALTER TABLE `CustomerDetails`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

CREATE TABLE Employees(
  emp_id int NOT NULL,
  firstname varchar(20) NOT NULL,
  lastname varchar(20) NOT NULL,
  middleinitial varchar(2) NOT NULL, 
  rank varchar(20) NOT NULL,
  username varchar(30) NOT NULL,
  password varchar(50) NOT NULL,
  last_login DATETIME NOT NULL,
  entryStatus varchar (255) default 'ok',
  PRIMARY KEY (emp_id)
);

ALTER TABLE `Employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO Employees (firstname, lastname, middleinitial, rank, username, password, last_login)
VALUES ('Apple', 'Juice', 'L.', 'admin', 'admin123def', md5('admin'), 0);

CREATE TABLE SUPPLIER(
  supplier_id int NOT NULL,
  name varchar(40) NOT NULL,
  email varchar(40) not NULL,
  address varchar(40) NOT NULL,
  entryStatus varchar (255) default 'ok',
  PRIMARY KEY (supplier_id)
);

INSERT INTO SUPPLIER (name, email, address)
VALUES ('stub', 'stub', 'stub');

ALTER TABLE `SUPPLIER`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE PO(
  purchaseorder_ref int NOT NULL,
  emp_id int NOT NULL,
  supplier_id int default NULL,
  po_totalprice int NOT NULL,
  eta DATE default '0000-00-00',
  etd DATE default '0000-00-00',
  paymentmethod ENUM('cash','credit','none') default 'none',
  date_fulfilled DATETIME NOT NULL,
  purchaseorder_status ENUM('pending','complete','cancelled') Default 'pending',
  entryStatus varchar (255) default 'ok',
  CONSTRAINT FK_PO_emp_id FOREIGN KEY (emp_id) REFERENCES Employees(emp_id) ON UPDATE CASCADE,
  CONSTRAINT FK_SUP FOREIGN KEY (supplier_id) REFERENCES SUPPLIER(supplier_id) ON UPDATE CASCADE,
  PRIMARY KEY (purchaseorder_ref)
);

ALTER TABLE `PO`
  MODIFY `purchaseorder_ref` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE PO_LINE(
  POline_id int NOT NULL,
  purchaseorder_ref int NOT NULL,
  qty int NOT NULL,
  prodName varchar(50) NOT NULL,
  totalprice DECIMAL(10,2),
  entryStatus varchar (255) default 'ok',
  CONSTRAINT FK_PN_PO FOREIGN KEY (prodName) REFERENCES Product(name) ON UPDATE CASCADE,
  CONSTRAINT FK_POREF_PO FOREIGN KEY (purchaseorder_ref) REFERENCES PO(purchaseorder_ref) ON UPDATE CASCADE,
  PRIMARY KEY (POline_id)
);

ALTER TABLE `PO_LINE`
  MODIFY `POline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE DO(
  order_ref int NOT NULL,
  emp_id int NOT NULL,
  customer_id int DEFAULT NULL,
  order_status ENUM('not yet delivered', 'sold', 'for exit', 'exited') DEFAULT NULL,
  date_fulfilled DATE DEFAULT NULL,
  entryStatus varchar (255) default 'ok',
  comment varchar (255) default 'sold',
  CONSTRAINT FK_SKU FOREIGN KEY (customer_id) REFERENCES CustomerDetails(customer_id) ON UPDATE CASCADE,
  CONSTRAINT FK_OD_emp_id FOREIGN KEY (emp_id) REFERENCES Employees(emp_id) ON UPDATE CASCADE,
  PRIMARY KEY (order_ref)
);

ALTER TABLE `DO`
  MODIFY `order_ref` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE DO_LINE(
  orderline_id int NOT NULL,
  order_ref int NOT NULL,
  qty int NOT NULL,
  totalprice DECIMAL(10,2) NOT NULL,
  prodName varchar(50) NOT NULL,
  entryStatus varchar (255) default 'ok',
  CONSTRAINT FK_PN_DO FOREIGN KEY (prodName) REFERENCES Product(name) ON UPDATE CASCADE,
  CONSTRAINT FK_DOREF_OD FOREIGN KEY (order_ref) REFERENCES DO(order_ref) ON UPDATE CASCADE,
  PRIMARY KEY (orderline_id)
);

ALTER TABLE `DO_LINE`
  MODIFY `orderline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE LOGS(
  log_id int NOT NULL,
  log_type varchar(1) NOT NULL,
  name varchar(50) NOT NULL,
  qty int NOT NULL,
  date_fulfilled DATE NOT NULL,
  CONSTRAINT FK_PN_LOGS FOREIGN KEY (name) REFERENCES Product(name) ON UPDATE CASCADE,
  PRIMARY KEY (log_id)
);

ALTER TABLE `LOGS`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;