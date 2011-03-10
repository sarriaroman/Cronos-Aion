CREATE TABLE `api_users` (
  `id` int(12) NOT NULL auto_increment,
  `uid` int(7) NOT NULL,
  `api_key` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `api_log` (
  `id` int(11) NOT NULL auto_increment,
  `level` varchar(20) NOT NULL,
  `did` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8_spanish_ci;

CREATE TABLE `config` (
  `config_key` varchar(50) character set latin1 NOT NULL,
  `config_value` text character set latin1 NOT NULL,
  PRIMARY KEY  (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `aion_log` (
  `id` int(11) NOT NULL auto_increment,
  `description` text NOT NULL,
  `todo` tinyint(4) NOT NULL default '1',
  `created` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8_spanish_ci;

CREATE TABLE `users` (
  `id` int(7) NOT NULL auto_increment,
  `username` varchar(255) character set latin1 NOT NULL,
  `password` varchar(255) character set latin1 NOT NULL,
  `name` varchar(255) character set latin1 NOT NULL,
  `lastname` varchar(255) character set latin1 NOT NULL,
  `DNI` varchar(30) character set latin1 NOT NULL,
  `email` varchar(255) character set latin1 default NULL,
  `gender` varchar(45) collate utf8_spanish_ci NOT NULL,
  `birthdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `roleid` int(4) NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`,`email`),
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `config` (`config_key`,`config_value`)
VALUES ('developer:enabled', 'true');

INSERT INTO `aion_log` (`description`,`todo`,`created`)
VALUES ('Panel instalado exitosamente | Installed succesful', '0', NOW());