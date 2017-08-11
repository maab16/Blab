<?php

$groupsSql = "CREATE TABLE groups(
		    id int not null AUTO_INCREMENT PRIMARY KEY,
		    group_name varchar(100) not null UNIQUE,
		    permission text not null,
		    created_at datetime not null,
		    updated_at datetime not null
    	)";

$customersSql = "CREATE TABLE customers(
			id int not null AUTO_INCREMENT PRIMARY KEY,
			username varchar(100) not null UNIQUE,
			password varchar(255) not null,
			salt varchar(50) not null,
			email varchar(100) not null UNIQUE,
			active int(1) not null,
			grp int not null,
			created_at datetime not null,
			updated_at datetime not null,
			FOREIGN KEY (grp) REFERENCES groups(id)
    	)";

$profileSql = "CREATE TABLE profile(
		    id int not null AUTO_INCREMENT PRIMARY KEY,
		    customer_id int not null,
		    fname varchar(100) not null,
		    lname varchar(100) not null,
		    gender varchar(6) not null,
		    user_image text,
		    birth_date varchar(100) not null,
		    country_code varchar(10) not null,
		    city varchar(50) not null,
		    zip_code varchar(50) not null,
		    phone varchar(30) not null,
		    mobile varchar(50) not null,
		    address text,
		    comphany varchar(100) not null,
		    website varchar(100) not null,
		    CONSTRAINT FK_CUSTOMER FOREIGN KEY (customer_id)
		    REFERENCES customers(id)
    	)";
$companiesSql = "CREATE TABLE companies(
		    id int not null AUTO_INCREMENT PRIMARY KEY,
		    company_name varchar(100) not null UNIQUE,
		    email varchar(100) not null UNIQUE,
		    company_image text not null,
		    address text not null,
		    vat_no varchar(100) not null UNIQUE,
		    reg_no varchar(100) not null UNIQUE,
		    phone varchar(50) not null UNIQUE,
		    website varchar(128) not null,
		    created_at datetime not null,
		    updated_at datetime not null
    	)";
$availabilitiesSql = "CREATE TABLE availabilities(
			id int not null AUTO_INCREMENT,
			code varchar(100) not null,
			title varchar(100) not null,
			created_at datetime not null,
			updated_at datetime not null,
			PRIMARY KEY(id),
			CONSTRAINT UC_Availabilty_Code UNIQUE (code)
		)";
$productsSql = "CREATE TABLE products(
			id int not null AUTO_INCREMENT PRIMARY KEY,
			code varchar(100) not null,
			title varchar(255) not null,
			comphany int not null,
			price int not null,
			currency varchar(50) not null,
			product_image text,
			status varchar(100) not null,
			created_at datetime,
			updated_at datetime,
			CONSTRAINT UC_Product_Code UNIQUE (code),
			CONSTRAINT UC_Product_Company UNIQUE (comphany),
			CONSTRAINT FK_COMPANY FOREIGN KEY (comphany) REFERENCES companies(id),
			CONSTRAINT FK_STATUS FOREIGN KEY (status) REFERENCES availabilities(code)
		)";
$customerProductsSql = "CREATE TABLE customer_products(
			id int not null AUTO_INCREMENT PRIMARY KEY,
			customer_id int not null,
			product_id int not null,
			qty int not null,
			vat_amount int not null,
			created_at datetime not null,
			updated_at datetime not null,
			CONSTRAINT UC_Customer_Product UNIQUE(customer_id,product_id),
			CONSTRAINT FK_CUSTOMER_ID FOREIGN KEY(product_id) REFERENCES customers(id),
			CONSTRAINT FK_PRODUCT_ID FOREIGN KEY(product_id) REFERENCES products(id)
		)";