CREATE DATABASE dbScervino;
USE dbScervino;
show databases;


CREATE TABLE tblAdmin (
  idAdmin INT NOT NULL AUTO_INCREMENT,
  user VARCHAR(80) NOT NULL,
  password VARCHAR(500) NOT NULL,
  PRIMARY KEY (idAdmin),
  UNIQUE INDEX (idAdmin)
  );



CREATE TABLE tblClient (
  idClient INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(80) NOT NULL,
  email VARCHAR(200) NOT NULL,
  password VARCHAR(500) NOT NULL,
  cpf VARCHAR(18) NOT NULL,
  birthDate DATE NOT NULL,
  PRIMARY KEY (idClient),
  UNIQUE INDEX (idClient)
  );




CREATE TABLE tblCategory (
  idCategory INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(80) NOT NULL,
  icon VARCHAR(500) NOT NULL,
  backgroundImage VARCHAR(500) NOT NULL,
  PRIMARY KEY (idCategory),
  UNIQUE INDEX (idCategory)
  );
  
  
  
  
  
  create table tblColor (
	idColor INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    hexa varchar(10) NOT NULL,
    PRIMARY KEY (idColor),
	UNIQUE INDEX (idColor)
);
  



CREATE TABLE tblProduct (
  idProduct INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(80) NOT NULL,
  price FLOAT NOT NULL,
  description TEXT NOT NULL,
  qtdInventory INT NOT NULL,
  discount INT NULL,
  idColor INT NOT NULL,
  idCategory INT NOT NULL,
  PRIMARY KEY (idProduct),
  UNIQUE INDEX (idProduct),
  CONSTRAINT fk_tblProduct_tblColor
  FOREIGN KEY (idColor)
  REFERENCES tblColor (idColor),
  CONSTRAINT fk_tblProduct_tblCategory
  FOREIGN KEY (idCategory)
  REFERENCES tblCategory (idCategory)
);

CREATE TABLE tblImageProduct (
  idImageProduct INT NOT NULL AUTO_INCREMENT,
  image VARCHAR(500) NOT NULL,
  idProduct INT NOT NULL,
  PRIMARY KEY (idImageProduct),
  UNIQUE INDEX (idImageProduct),
  CONSTRAINT fk_tblImageProduct_tblProduct
  FOREIGN KEY (idProduct)
  REFERENCES tblProduct (idProduct)
);

 



CREATE TABLE tblFeedback (
  idFeedback INT NOT NULL,
  stars INT NOT NULL,
  comment TEXT NOT NULL,
  idClient INT NOT NULL,
  idProduct INT NOT NULL,
   PRIMARY KEY (idFeedback),
  UNIQUE INDEX (idFeedback),
  CONSTRAINT fk_Feedback_tblClient
    FOREIGN KEY (idClient)
    REFERENCES tblClient (idClient),
  CONSTRAINT fk_Feedback_tblProduct1
    FOREIGN KEY (idProduct)
    REFERENCES tblProduct (idProduct)
    );


CREATE TABLE tblClient_Product (
  idClient_Product INT NOT NULL AUTO_INCREMENT,
  qtd INT NOT NULL,
  idClient INT NOT NULL,
  idProduct INT NOT NULL,
  PRIMARY KEY (idClient_Product),
  UNIQUE INDEX (idClient_Product),
  CONSTRAINT fk_tblClient_Product_tblClient1
  FOREIGN KEY (idClient)
REFERENCES tblClient (idClient),
  CONSTRAINT fk_tblClient_Product_tblProduct1
    FOREIGN KEY (idProduct)
    REFERENCES tblProduct (idProduct)
    );