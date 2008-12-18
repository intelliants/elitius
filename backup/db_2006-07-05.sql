CREATE DATABASE `xoopartner`;
CREATE TABLE `xoopart_admins` (
	`id` tinyint(3) unsigned NOT NULL auto_increment,
	`username` varchar(50) NOT NULL,
	`password` varchar(32) NOT NULL,
	`email` varchar(100) NOT NULL,
	`super` enum('0','1') NOT NULL DEFAULT '0',
	`date` date NOT NULL DEFAULT '0000-00-00',
	`time` time NOT NULL DEFAULT '00:00:00',
   PRIMARY KEY (id)
);

CREATE TABLE `xoopart_ads` (
	`id` int(10) NOT NULL auto_increment,
	`title` varchar(64) NOT NULL,
	`content` text NOT NULL,
	`visible` enum('0','1') NOT NULL DEFAULT '0',
   PRIMARY KEY (id)
);

CREATE TABLE `xoopart_affiliates` (
	`id` int(10) NOT NULL auto_increment,
	`date_reg` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`username` varchar(50) NOT NULL,
	`password` varchar(32) NOT NULL,
	`approved` enum('0','1') NOT NULL DEFAULT '0',
	`firstname` varchar(50) NOT NULL,
	`lastname` varchar(50) NOT NULL,
	`email` varchar(100) NOT NULL,
	`address` varchar(64) NOT NULL,
	`city` varchar(64) NOT NULL,
	`state` varchar(40) NOT NULL,
	`zip` varchar(20) NOT NULL,
	`country` varchar(64) NOT NULL,
	`phone` varchar(40) NOT NULL,
	`fax` varchar(40) NOT NULL,
	`url` varchar(128) NOT NULL,
	`hits` int(255) NOT NULL DEFAULT '0',
	`sales` int(255) NOT NULL DEFAULT '0',
	`level` int(5) NOT NULL DEFAULT '0',
	`taxid` varchar(50) NOT NULL,
	`check` varchar(64) NOT NULL,
	`company` varchar(64) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id)
);

CREATE TABLE `xoopart_banners` (
	`id` int(3) NOT NULL auto_increment,
	`visible` enum('0','1') NOT NULL DEFAULT '0',
	`name` varchar(255) NOT NULL,
	`x` int(10) NOT NULL DEFAULT '0',
	`y` int(10) NOT NULL DEFAULT '0',
	`path` varchar(64) NOT NULL,
	`desc` text NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE `xoopart_config` (
	`id` int(4) NOT NULL auto_increment,
	`id_group` tinyint(4) NOT NULL DEFAULT '0',
	`name` varchar(100) NOT NULL,
	`value` text NOT NULL,
	`multiple_values` text NOT NULL,
	`type` enum('text','textarea','checkbox','radio','select','divider','hidden') NOT NULL DEFAULT 'text',
	`description` text NOT NULL,
	`order` float NOT NULL DEFAULT '0',
	`hint` text NOT NULL,
   PRIMARY KEY (id),
   KEY id (id)
);

CREATE TABLE `xoopart_config_categs` (
	`id` smallint(6) NOT NULL auto_increment,
	`title` varchar(150) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE `xoopart_config_groups` (
	`id` smallint(6) NOT NULL auto_increment,
	`id_categ` smallint(6) NOT NULL DEFAULT '0',
	`title` varchar(150) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE `xoopart_contacts` (
	`id` int(8) NOT NULL auto_increment,
	`fullname` varchar(50) NOT NULL,
	`email` varchar(100) NOT NULL,
	`reason` text NOT NULL,
	`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`ip` varchar(15) NOT NULL,
   UNIQUE id (id)
);

CREATE TABLE `xoopart_emails` (
	`id` int(3) NOT NULL auto_increment,
	`name` varchar(30) NOT NULL,
	`description` varchar(150) NOT NULL,
	`subject` varchar(150) NOT NULL,
	`body` text NOT NULL,
	`footer` text NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE `xoopart_sales` (
	`id` int(100) NOT NULL auto_increment,
	`aff_id` int(255) NOT NULL DEFAULT '0',
	`date` date NOT NULL DEFAULT '0000-00-00',
	`time` time NOT NULL DEFAULT '00:00:00',
	`payment` decimal(10,2) NOT NULL DEFAULT '0.00',
	`approved` enum('0','1') NOT NULL DEFAULT '0',
	`ip` varchar(64) NOT NULL,
	`order_number` varchar(64) NOT NULL,
	`tracking` varchar(64) NOT NULL,
	`merchant` varchar(32) NOT NULL,
   PRIMARY KEY (id),
   KEY record (id)
);

CREATE TABLE `xoopart_tracking` (
	`id` int(255) NOT NULL auto_increment,
	`aff_id` int(255) NOT NULL DEFAULT '0',
	`ip` varchar(64) NOT NULL,
	`referrer` varchar(128) NOT NULL,
	`date` date NOT NULL DEFAULT '0000-00-00',
	`time` time NOT NULL DEFAULT '00:00:00',
   PRIMARY KEY (id),
   KEY record (id)
);

