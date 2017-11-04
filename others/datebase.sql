
CREATE TABLE IF NOT EXISTS `user_info` (
	`UIid` int AUTO_INCREMENT,
	`Uuserid` char(20) default ' ',
	`Uusername` char(20) default ' ',
	`Uadress` char(20) default ' ',
	`Uuserphone` char(20) default ' ',
	`Uuserwechat` char(20) default ' ',
	`Uuseremail` char(20) default ' ',
	`Uuserqq` char(20) default ' ',
	`Uuserlang` char(20) default ' ',
	PRIMARY KEY(`UIid`)
)	ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `user_rela` (
	`URid` int AUTO_INCREMENT,
	`Uuserid` char(20) default ' ',
	`URrela` char(20) default ' ',
	PRIMARY KEY(`URid`)
)   ENGINE=MyISAM DEFAULT CHARSET=utf8;


