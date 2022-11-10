-- Create Database ticketing
CREATE DATABASE ticketing;

-- Create Table tl_ticket 
CREATE TABLE 
	IF NOT EXISTS ticketing.tl_ticket (
		id INT(11) NOT NULL auto_increment,
		event_id INT(11) NOT NULL,
		ticket_code VARCHAR(10) NOT NULL,
		`status` VARCHAR(20) DEFAULT 'available',
		created_date DATETIME DEFAULT current_timestamp(),
		created_by varchar(20) DEFAULT 'SYSTEM',
		updated_date DATETIME DEFAULT NULL,
		PRIMARY KEY (id),
		UNIQUE KEY `uc_event_id_ticket_code` (event_id, ticket_code)
	) engine=InnoDB auto_increment=36 DEFAULT CHARSET=utf8mb4;
