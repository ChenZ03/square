CREATE TABLE `Users` (
	`user_id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`isAdmin` BOOLEAN(0) NOT NULL DEFAULT '0',
	`field` varchar(255) NOT NULL,
	`organization` varchar(255) NOT NULL,
	PRIMARY KEY (`user_id`)
);

CREATE TABLE `Wallet` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`balance` FLOAT(11,2) NOT NULL,
	`expenses` FLOAT(11,2) NOT NULL,
	`food` FLOAT(11,2) NOT NULL,
	`entertainment` FLOAT(11,2) NOT NULL,
	`accessories` FLOAT(11,2) NOT NULL,
	`others` FLOAT(11,2) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Task` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`organization_id` INT(11) NOT NULL,
	`title` varchar(255) NOT NULL,
	`description` varchar(255) NOT NULL,
	`image` varchar(255) NOT NULL,
	`due_date` DATE NOT NULL,
	`done` BOOLEAN NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Event` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`organization_id` INT(11) NOT NULL,
	`title` varchar(255) NOT NULL,
	`description` varchar(255) NOT NULL,
	`date` DATE NOT NULL,
	`image` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Organization` (
	`id` varchar(255) NOT NULL,
	`name` varchar(255) NOT NULL,
	`member_count` INT(11) NOT NULL,
	`member_balance` FLOAT(11,2) NOT NULL,
	`member_expenses` FLOAT(11,2) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Goals` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`organization_id` INT(11) NOT NULL,
	`title` varchar(255) NOT NULL,
	`description` varchar(255) NOT NULL,
	`achieved` BOOLEAN NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Transactions` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`wallet_id` FLOAT(11,2) NOT NULL,
	`amount` FLOAT(11,2) NOT NULL,
	`meal_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Meal` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`price` FLOAT(11,2) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `Users` ADD CONSTRAINT `Users_fk0` FOREIGN KEY (`organization`) REFERENCES `Organization`(`id`);

ALTER TABLE `Wallet` ADD CONSTRAINT `Wallet_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk1` FOREIGN KEY (`organization_id`) REFERENCES `Organization`(`id`);

ALTER TABLE `Event` ADD CONSTRAINT `Event_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`);

ALTER TABLE `Event` ADD CONSTRAINT `Event_fk1` FOREIGN KEY (`organization_id`) REFERENCES `Organization`(`id`);

ALTER TABLE `Goals` ADD CONSTRAINT `Goals_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`);

ALTER TABLE `Goals` ADD CONSTRAINT `Goals_fk1` FOREIGN KEY (`organization_id`) REFERENCES `Organization`(`id`);

ALTER TABLE `Transactions` ADD CONSTRAINT `Transactions_fk0` FOREIGN KEY (`wallet_id`) REFERENCES `Wallet`(`id`);

ALTER TABLE `Transactions` ADD CONSTRAINT `Transactions_fk1` FOREIGN KEY (`meal_id`) REFERENCES `Meal`(`id`);









