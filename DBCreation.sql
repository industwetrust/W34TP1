CREATE DATABASE TPW34;

USE TPW34;

CREATE TABLE Customers(
  CustomerID INT NOT NULL AUTO_INCREMENT,
  Username VARCHAR(60) NOT NULL,
  Password VARCHAR(60) NOT NULL,
  Phone VARCHAR(15) NOT NULL,
  Email VARCHAR(255),
  FirstName VARCHAR(60),
  LastName VARCHAR(60),
  RegisterDate DATE,
  PRIMARY KEY (CustomerID)
);

CREATE TABLE Addresses(
  AddressID INT NOT NULL AUTO_INCREMENT,
  CustomerID INT NOT NULL,
  Country VARCHAR(50) NOT NULL,
  Province VARCHAR(50) NOT NULL,
  City VARCHAR(50) NOT NULL,
  Address VARCHAR(100) NOT NULL,
  IsDefaultShipping BOOLEAN DEFAULT 0,
  IsDefaultBilling BOOLEAN DEFAULT 0,
  PRIMARY KEY (AddressID),
  FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

CREATE TABLE Categories(
  CategoryID INT NOT NULL AUTO_INCREMENT,
  CategoryName VARCHAR(60) NOT NULL,
  Description TEXT(2048),
  PRIMARY KEY (CategoryID)
);

CREATE TABLE Products(
  ProductID INT NOT NULL AUTO_INCREMENT,
  CategoryID INT NOT NULL,
  ProductName VARCHAR(60) NOT NULL,
  Price NUMERIC(9,2),
  UnitsInStock INT,
  PRIMARY KEY (ProductID),
  FOREIGN KEY (CategoryID) REFERENCES Categories(CategoryID)
);

CREATE TABLE ProductImages(
  ImageID INT NOT NULL AUTO_INCREMENT,
  ProductID INT NOT NULL,
  ImageURL VARCHAR(2048) NOT NULL,
  PRIMARY KEY (ImageID),
  FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

CREATE TABLE Shippers (
  ShipperID INT NOT NULL AUTO_INCREMENT,
  ShipperName VARCHAR(100) NOT NULL,
  ShipperPhone VARCHAR(15),
  ShipperWebsite VARCHAR(2048),
  PRIMARY KEY (ShipperID)
);

CREATE TABLE Orders (
  OrderID INT NOT NULL AUTO_INCREMENT,
  CustomerID INT NOT NULL,
  ShipperID INT NOT NULL,
  BillingAddress INT NOT NULL,
  ShippingAddress INT NOT NULL,
  OrderDate DATE,
  ShipDate DATE,
  PRIMARY KEY (OrderID),
  FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
  FOREIGN KEY (ShipperID) REFERENCES Shippers(ShipperID),
  FOREIGN KEY (BillingAddress) REFERENCES Addresses(AddressID),
  FOREIGN KEY (ShippingAddress) REFERENCES Addresses(AddressID)
);

CREATE TABLE OrderDetail (
  OrderID INT NOT NULL,
  ProductID INT NOT NULL,
  Quantity INT NOT NULL,
  primary key (OrderID, ProductID),
  FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
  FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);