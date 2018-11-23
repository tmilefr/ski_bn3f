ALTER TABLE `users` ADD `driver` INT(5) NOT NULL AFTER `country`;

ALTER TABLE `inputs` ADD `driver` INT(5) NOT NULL AFTER `billed`;

/* RGP */
ALTER TABLE `family`
  DROP `adress`,
  DROP `postalcode`,
  DROP `town`;
  
ALTER TABLE `users`
  DROP `adress`,
  DROP `postalcode`,
  DROP `town`;


CREATE TABLE `sendmail` (
  `id` int(15) NOT NULL,
  `date` datetime NOT NULL,
  `user` int(15) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `log` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `sendmail`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sendmail`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
