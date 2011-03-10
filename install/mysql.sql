CREATE TABLE IF NOT EXISTS `config` (
  `config_key` varchar(50) NOT NULL,
  `config_value` text NOT NULL,
  PRIMARY KEY  (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `aion_log` (
`id` int(11) NOT NULL auto_increment,
  `description` text NOT NULL,
  `todo` tinyint(4) NOT NULL default '1',
  `created` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(7) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `DNI` varchar(30) NOT NULL,
  `email` varchar(255) default NULL,
  `gender` varchar(45) NOT NULL,
  `birthdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `roleid` int(4) NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(7) NOT NULL auto_increment,
  `invoke_name` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `version` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `invoke_name` (`invoke_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `aion_log` (`description`,`todo`,`created`)
VALUES ('Panel instalado exitosamente | Installed succesful', '0', NOW());

INSERT INTO `config` (`config_key`,`config_value`)
VALUES ('jquery:version', '1.5.1');