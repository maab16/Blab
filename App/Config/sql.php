<?php

$groupsSql = "CREATE TABLE groups(
		    id int not null AUTO_INCREMENT PRIMARY KEY,
		    group_name varchar(100) not null UNIQUE,
		    permission text not null,
		    created_at datetime not null,
		    updated_at datetime not null
    	)";

$userStatus = "CREATE TABLE user_status(
		    id int not null AUTO_INCREMENT PRIMARY KEY,
		    status_id int not null UNIQUE,
		    title varchar(100) not null UNIQUE,
		    created_at datetime,
		    updated_at datetime
		)";

$customersSql = "CREATE TABLE users(
			id int not null AUTO_INCREMENT PRIMARY KEY,
			username varchar(100) not null UNIQUE,
			password varchar(255) not null,
			salt varchar(50) not null,
			email varchar(100) not null UNIQUE,
			active int(1) not null DEFAULT 0,
			grp int not null DEFAULT 1,
			created_at datetime not null,
			updated_at datetime not null,
			FOREIGN KEY (grp) REFERENCES groups(id),
			FOREIGN KEY (active) REFERENCES user_status(status_id)
    	)";

$profileSql = "CREATE TABLE profiles(
		    id int not null AUTO_INCREMENT PRIMARY KEY,
		    user_id int not null,
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
		    company varchar(100) not null,
		    website varchar(100) not null,
		    CONSTRAINT FK_USER FOREIGN KEY (user_id)
		    REFERENCES users(id)
    	)";
$usersSessionSql = "CREATE TABLE users_session(
			id int not null AUTO_INCREMENT PRIMARY KEY,
			user_id int not null,
			hash varchar(100) not null,
			CONSTRAINT FK_SESSION_ID FOREIGN KEY (user_id)
		    REFERENCES users(id)
		)";