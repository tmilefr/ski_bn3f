/*CREATE TABLE `users` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`role_id` INT(11) NOT NULL,
`email` VARCHAR(50) NOT NULL,
`password` VARCHAR(64) NOT NULL,
`is_active` ENUM('1','0') NOT NULL DEFAULT '1',
PRIMARY KEY (`id`),
INDEX `FK_users_roles` (`role_id`),
CONSTRAINT `FK_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;*/

CREATE TABLE `roles` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`role_name` VARCHAR(50) NOT NULL,
PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

CREATE TABLE `resources` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`controller` VARCHAR(50) NOT NULL,
PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

CREATE TABLE `permissions` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`resource_id` INT(11) NOT NULL DEFAULT '0',
`action` VARCHAR(50) NOT NULL,
PRIMARY KEY (`id`),
INDEX `FK_permissions_resources` (`resource_id`),
CONSTRAINT `FK_permissions_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;
CREATE TABLE `role_permissions` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`role_id` INT(11) NOT NULL,
`permission_id` INT(11) NOT NULL,
PRIMARY KEY (`id`),
INDEX `FK_role_permissions_permissions` (`permission_id`),
INDEX `FK_role_permissions_roles` (`role_id`),
CONSTRAINT `FK_role_permissions_permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
CONSTRAINT `FK_role_permissions_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

ALTER TABLE `users` ADD `role_id` INT(5) NOT NULL AFTER `driver`;
ALTER TABLE `users` ADD `password` VARCHAR(255) NOT NULL AFTER `role_id`;
