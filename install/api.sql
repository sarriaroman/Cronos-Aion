CREATE TABLE IF NOT EXISTS `api_users` (
  `id` int(12) NOT NULL auto_increment,
  `uid` int(7) NOT NULL,
  `api_key` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `api_log` (
  `id` int(11) NOT NULL auto_increment,
  `level` varchar(20) NOT NULL,
  `did` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `config` (`config_key`,`config_value`)
VALUES ('developer:enabled', 'true');