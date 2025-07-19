DELIMITER $$

CREATE PROCEDURE `GetIpData` ( IN `uid` INT, OUT `ipdata1` VARCHAR( 1000 ) ) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN START TRANSACTION;

SELECT ipdata
INTO ipdata1
FROM users
WHERE ID = uid;

COMMIT ;

END$$

CREATE DEFINER = `root`@`localhost` PROCEDURE `AddLoginLog` ( IN `uid` INT, IN `login1` VARCHAR( 30 ) , IN `ip1` VARCHAR( 30 ) , IN `act` INT ) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN DECLARE tmp_log VARCHAR( 30 ) ;

START TRANSACTION;

IF( login1 IS NULL OR login1 = '' ) THEN SELECT `name` 
INTO tmp_log
FROM users
WHERE `ID` = uid;

ELSE SET tmp_log = login1;

END IF ;

INSERT INTO login_log( `data` , `ip` , `userid` , `login` , `action` ) 
VALUES (now( ) , ip1, uid, tmp_log, act
);

COMMIT ;

END$$

DELIMITER ;

ALTER TABLE `users` CHANGE `Prompt` `Prompt` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
CHANGE `answer` `answer` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

CREATE TABLE IF NOT EXISTS `antibrut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `last_date_fail` bigint(20) NOT NULL,
  `fail_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `changepass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(16) CHARACTER SET cp1251 NOT NULL,
  `data` datetime NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `donate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_id` int(11) NOT NULL,
  `don_system` VARCHAR( 30 ) NOT NULL DEFAULT 'UnitPay',
  `data` datetime NOT NULL,
  `out_summ` float(16,2) NOT NULL,
  `don_kurs` float(16,2) NOT NULL,
  `money` int(11) NOT NULL,
  `act_bonus` int(11) NOT NULL DEFAULT '0',
  `bonus_money` int(11) NOT NULL DEFAULT '0',
  `login` varchar(25) NOT NULL,
  `userid` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `klan` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `desc` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `level` smallint(11) NOT NULL,
  `masterid` int(11) NOT NULL,
  `mastername` varchar(50) CHARACTER SET utf8 NOT NULL,
  `members` int(11) NOT NULL,
  `terr1` tinyint(4) NOT NULL DEFAULT '0',
  `terr2` tinyint(4) NOT NULL DEFAULT '0',
  `terr3` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `klan_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klanid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `maxcount` int(11) NOT NULL DEFAULT '1',
  `data` varchar(1000) NOT NULL,
  `mask` int(11) NOT NULL,
  `proctype` int(11) NOT NULL DEFAULT '0',
  `expire` int(11) NOT NULL DEFAULT '0',
  `costgold` int(11) NOT NULL DEFAULT '0',
  `costsilver` int(11) NOT NULL DEFAULT '0',
  `cost_item_id` int(11) NOT NULL,
  `cost_item_count` int(11) NOT NULL,
  `desc` varchar(100) CHARACTER SET utf8 NOT NULL,
  `buycount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `lklogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `ip` varchar(30) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gold_rest` int(11) NOT NULL,
  `silver_rest` int(11) NOT NULL,
  `desc` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

ALTER TABLE `lklogs` ADD INDEX(`userid`);

CREATE TABLE IF NOT EXISTS `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `action` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

ALTER TABLE `login_log` ADD INDEX(`userid`);

CREATE TABLE IF NOT EXISTS `mmotop_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `login` varchar(25) CHARACTER SET utf8 NOT NULL,
  `userid` int(11) NOT NULL,
  `vote_type` tinyint(4) NOT NULL,
  `points` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `qtop_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `vote_id` int(11) NOT NULL,
  `vote_type` tinyint(4) NOT NULL,
  `points` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `shop_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `shop_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '1',
  `maxcount` int(11) NOT NULL DEFAULT '1',
  `data` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `mask` int(11) NOT NULL DEFAULT '0',
  `proctype` int(11) NOT NULL DEFAULT '0',
  `subcat` int(11) NOT NULL DEFAULT '0',
  `cost_timeless` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `cost_expire` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `expire` int(11) NOT NULL DEFAULT '0',
  `discount_data` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `desc` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `rest` int(11) NOT NULL DEFAULT '-1',
  `buycount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `shop_names` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `icon` varchar(128) CHARACTER SET utf8 NOT NULL,
  `list` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `shop_subcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '1',
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(4) NOT NULL,
  `userid` int(11) NOT NULL,
  `rolename` varchar(100) CHARACTER SET utf8 NOT NULL,
  `rolelevel` int(4) NOT NULL,
  `rolestatus` int(4) NOT NULL,
  `rolegender` int(4) NOT NULL,
  `roleprof` int(4) NOT NULL,
  `rolerep` int(8) NOT NULL,
  `redname` int(11) NOT NULL,
  `rednametime` int(11) NOT NULL,
  `factionid` int(11) NOT NULL,
  `factionrole` smallint(6) NOT NULL,
  `pinknametime` int(11) NOT NULL,
  `level2` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `mp` int(11) NOT NULL,
  `sp` int(11) NOT NULL,
  `timeused` bigint(20) NOT NULL,
  `goldadd` int(11) NOT NULL,
  `goldbuy` int(11) NOT NULL,
  `goldsell` int(11) NOT NULL,
  `goldused` int(11) NOT NULL,
  `pk_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roleid` (`roleid`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251;

ALTER TABLE `users` ADD `lkgold` INT NOT NULL DEFAULT '0', ADD `lksilver` INT NOT NULL DEFAULT '0', ADD `referal` INT NOT NULL DEFAULT '0', ADD `ref_status` INT NOT NULL DEFAULT '0', ADD `ref_bonus` INT NOT NULL DEFAULT '0', ADD `bonus_data` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , ADD `ipdata` VARCHAR( 10000 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `mmotop_data` CHANGE `points` `points` VARCHAR( 20 ) NOT NULL, ADD `send_item` TINYINT NOT NULL DEFAULT '0' AFTER `points` ;
ALTER TABLE `qtop_data` CHANGE `points` `points` VARCHAR( 20 ) NOT NULL, ADD `send_item` TINYINT NOT NULL DEFAULT '0' AFTER `points` ;
ALTER TABLE `mmotop_data` ADD `name` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ip` ;
ALTER TABLE `qtop_data` ADD `name` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ip` ;
CREATE TABLE IF NOT EXISTS `shop_buffs` (`id` int(11) NOT NULL AUTO_INCREMENT, `filter_id` int(11) NOT NULL DEFAULT '0', `name` varchar(35) CHARACTER SET utf8 NOT NULL, `icon` longtext CHARACTER SET utf8 NOT NULL, `value` int(11) NOT NULL DEFAULT '10', `class_mask` int(11) NOT NULL DEFAULT '1023',  `expire` int(11) NOT NULL DEFAULT '1800', `cost` varchar(35) CHARACTER SET utf8 NOT NULL DEFAULT '15', `enabled` tinyint(4) NOT NULL DEFAULT '0',  `buy_count` int(11) NOT NULL DEFAULT '0', `description` text CHARACTER SET utf8 NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4096, 'Замедление', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADAElEQVQ4jQXBy3LbVACA4f8cHUmWbcm3JsRJE0LxBFIYCgxseQNWPBLDhhULtmx4hc7AIrAqbYEFhDQlJdeJ4yR24rsl637E94k3P3aLLX+GU3SJ9ZCZA0sBOimQRpNJWEfbLot8TpqNKTPGE4rs3iTw2qiNcM7Tb7/hqy8fYm+brNY9WH8Ia2+DbrAt3wUcaAH+PSTX6JMz0CaHgxFKG5esvecTOS+pmCmUNtH+AdmphbX6GFqfwcoOESmyEjHtHWDUpkQyIy81UQlzHj9pU2n3oTZiMr5njkNcQN2SSHeFmtkgtSsE0QzVMjk5PCUdCGxRRQWijDPLYbsC+Yh+d8rF5JZlUVCfrtCpfc4Du8Yi1DhmE82QyLc5Pbzmwx0XtYxS1ht1WIzAkVzfzTjqanIFdWPCVlaAzmhUXShi+n6IbVWwlEceFkivJJFmwjS+Acvk4FLz+gqGmc1x95a/9v8GmRBNrxEipFZRZHnET3s/k2cxUkQh571LVLlJIm1aW6tkFlz0Yk67Q14f/csP339H/+I/iBfEccqz354TZylJoVFmniOkwzIpIbWH1zRJ0ztKTo0kSvh17wWbJ2ccv3pFZ6fDbOmzv3/BLBHMBag009zdT8kbKaWNEh/tPuLgeMTRaQ+hDeIIzs8G3PQG7P3yJ9MYqplNU6zjI5CZtChwGA8D+t0eMprzZGeD999ZxbETKjYUBYQRCMsglyZBYmFYZabLALXQCm25TBYFTihpGha7nQ7IErLk4voBv/9zRbkkWSSCRDooq8ZwNsesOKhRIZmlgNvmzVUPNzrHfbCB49b55NM29YlPpbnJ7fU9vrZpSY/xbUDLMvFDH2WbLi//OOHjL5rEhiYfl4m1QdVzKVdddt/awqPNB62Cs/6Iy0TjpAF6MYMcVDmwuenHiBcDVjoNvMYGy4VBXJZUq5JcJ7SoY+QGDW+FZhJzNrml0l4j81PE06+fFeuGgZ9eMY/HGKpGKGAQTMmUQucSYxHRSAuiJGVgFoRCYPg5S634HyXWgJnMfA1KAAAAAElFTkSuQmCC', 20, 1023, 1800, '15|0', 0, 0, 'Замедляет скорость движения');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4100, 'Изоляция', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADUklEQVQ4jSXLSWxUdQDA4d+8939vZjpvuq9YqmjBTOlA00WqrUs1FaupVdJWPUjiSRMupmk0qLgQsYSLNxO9AHpSMWmCwUAhECC0aaUtYbFFutiVodjO0pl5+/Pgd/98t05YnpTKcL/UxPDZaBs6iuNCwMMxs4SzgAOGpxAPwF1VRxUelf8mKTQDiKyj89vgz4Q7aom01NHcXo7QIZGG6alFDn8xgCT7ScsByqofpXt/F7mmjpJI4WwaiKySZUls8NRrjVzSfJwan6bn+ScZvXubhvadnB3dAYYD/jA9nZ3EsnGMf2ZZvXaD1pomxKZnsmtvK/cCHpOKRWWhzKYHcSVFUgWqi8AfADXEr84DzMQagb9u8ck73axOzCLMsMaPx8+j1lXwdOM2+uuqyXehqS6KCRzv3Yfl9+PaJhlZpW//AWjronklRoHrQ4olk0SitZSHQ+S5DooN2YUlKoIBinFYGPqDqo01Zk4P0lcbhTd7eETR+Obot5iehJByBGFNIbW2SlG0GEuAkyfjR8YPHDvwAZ4skQkW0Nqxj/iVMfQ7MZ6t3EaO7SK5rovlmASDKqdGR4gDFJSSAa5NXGfqz5t0tXUwdukyRz/9jNjfMxQj4Vgutu0iyY5LNLKL2oYIw67MybUVBldmODM1Tmf3G6z7izn8/UkKSspICYjv3sGIlWbRdEk6CkJYLsNXR5jfAu++uAf/8jz9A0dgbJjejw8iaQqJDGgajC/OYUWfADWPubOzrJoGwkrGCakKvc3b0bPw1XMvgZWGV/bS8urrBKT/swmsqxK8UA8508TWFdb8AlGkBTj04dtMGvDWsS/B8hgausiEFsJUg0wu3KemqpyM57D9sSpYnofG3Rwqa2Dpp3NIqdQKj4ehTTHoSK1wfWYasTPCR/0HuT07z9jSAg+BZWzu3Zjk83iaqwXF9EdK2JqJIUrVIEKHkkyK91teJiwr9B35AaRCTnz9HXm5uQQTLm6eQr7l8F5jExW6hE+HEsNF5K67LP0yypmx89S0P8Ps73fInrtJg6eg+ooosjXqna1sZHRCisbchUm21O8BG3JSGr4rA5e9/E2DhJTmITpxRSbtgm35ME0bSbcxhcsDL4lnJqi0DEJZH5mEivCC/Ae9YHZyv+2PWQAAAABJRU5ErkJggg==', 10, 1023, 1800, '15|0', 0, 0, 'Лишает возможности атаковать и использовать умения (а также нормально выходить из игры)');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4109, 'Неповоротливость', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADU0lEQVQ4jQXBfUyUdQDA8e/zcgcc0HkWQ6wo/mjFojpNnJWIHrW1WDoITGEh0o0yIauxCTKdy7Ya6w+ImNqLmcFMQWEmIKMUogvoQBu6WGGCIledSXfAvTx3zz2/Ph+ppz0ghKHiNS2yYNL5TxfEYyYlrGAKGkiYWDKiLKk6ESmCYQQx6zpWYeZfPYRsCceIV8zo1nvYs8PJ71Yb16w2Xq94g6k0G9/NTFNz8hT/pKdQf66L095Zhv+a5cGVGSRHZGRF1eidGKEvPgQpMienxmhNjsLDMocegNO3RwjM/MTHf7pheYir1gj6KxvJ35KHoi8hDZyYE87Dx7l+ZwJ6W2FzAThyYPcuEAbEFEiIh4gGZgmsFljtIPnxPOodOciqkkBVaQXIqfByOXS2wr7d8MsgbC+Awx+ATUBqIrjHoXAnlOzkhfx8vJKBGlkMMdLvouN8E0Xbq2BqEva9C5KFyrZv6F+RzHTNHkhcAWd6oeUzrFlPkPm3gX9sCIZbbovH0moF5e1ik1cI5oKCmgPiuU86BMvtgq2V4qU7QcH9Twnuswtqjwk2vifIelOUH+oUakAymA8vwmU3l0xF0NAIb1Xh2lQASYnwwyA9WXZWjV8hrFjwLMD6QsGLms71Sz2oc2qMxvZPKZmegs3V4P0NXt0Ksg6GBgkK5Dm4Mu/jSaHj7x6le2CcSe88Zc+vRfYnx1NS7AT3GBxphrhEOPolmV8dAzmO7K7zsGYdbCliItcBGDAwxI1fh9GIIe0/5RGW1DTqpmdgtA8qC6CsFO4GQIvBhvUwNAgXu6G4FKr3kvGIHdvP42REPcixUIC6luPQ8CFsWAtJFnjmWZATeKh2P+nZuWBaBoNuaGuD5gamr7qYl3U0RUe919DA1Q8XvwYpBNteg6ZmWJ3LzQjQcYb0jnPc2lsHN2bhwlnIcWCvPkjSTT+yNaTR+MVRcn0LULwDHs0GxQaua5C5Bp7O4dbn31LxURNccEHv95T29dF14H1MhoK8LGJiVTiOyzllyJNh0jwy6zpGoGsMp0+htnAb/DjBaNMJ3na+A9UHGdlVT+fZTsKSjHSk+Q/h10DRw+iqzFQsyqIkkWQYhAIBoopEIBrBJwwiQR8rZZ1YKIhQVTzaXf4HQgV1eApEQSMAAAAASUVORK5CYII=', 50, 511, 1800, '15|0', 0, 0, 'Уменьшает силу физ атак');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4171, 'Антистан', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADSklEQVQ4jSXQz2tbBQDA8e97eXlJE5LmR5vm14xLXe2vbdrNUouXFodRYR4clelFJqjsIgjzoB56EkWGilNBSnsSRNBLe/AwHcpkY9LqJm5t1y1df6b50dgk77283x72D3wOH+HC4q4bdLyEXR2rqtIdyKKqGqrcQHd1mlYH4Mc0Bbyii2PXcWwTWwxypGYh1YQ2n556CZQmSHFijz/H+TdeJ9Eb5ZOZS1QPWnB3A5I5MBTQSyACNZ1LH19E6hRNaDXACUBigJTYw/Jvq4wNTPLnt+9TbsDM7CxzcwtYzTZotYeAHKBlVBAt/QBcIHIITC+9ySwvPz9JyIGfv18mbMBn751j5cpPzH15kWdPnyE6PAKHU6jtXaSIBAwOwgOLVDTEI9k4pmngk2Ry6TyzX1ylUHiGbBa6w928UjjLByNZlKDGyrV5JPs/B+oW6DbVUgnX0cnnZJJJCAZluqK9bKwZPHpIJhqKYTttTMVBNffR6vtIPVIerBBSpIPJE6McP9pPpeIgBUQ0BWS/n560zF4FvH6RiVMBDA80yLB1LYTYbgH+MAPHhvh3rci7H07z9jsX+OXyCl0RODYU5ebiKvUdg7AMjcrDc68HlFYb0RJ0Qk/1Y4QCfP3dR0yeLpDr60PVbK7/USPVCYXxPqS6Tu22QXFJo1y0abXAdkzEOgpNbAbHx/HnIH4iz42tO8zOX2a9qmA6kO6BiC9Eo6RT21TZKtb4e+kBlgOewTfPTy+VLDKpXqKZMMMTCcxklsV7Chv3mij7AvVtL5mIj3SPD1sI0DB06rRQKtt4Uq+em7774w2KUoyNlogbDnHy6QS7aoLV4ibF4n3WV+/j9cTZKes0LYtsf4RgIsLNpasIUwu33B9mrkPXEFgupH1MnTmJX4LNtRr68g7anS2SbR9W9YBqeYeOLpHYYz56uywkv9cDezsk0/3UvDLmRoV6UeOJsQ78njiJ4ThR+yhxDdRd+Orzb/jryjzcEnjrtReRJKcJ//xKaf02GCLy6CjR7RwLM3XimRjrCYmJkSN4MiB1wtjZJzn+wmGUpopYbiBMzf/udhohAqqJoBngeNFdiX1dYM9Rafga7KFQbbYIWCZ5RJSDJnFPJ4l9g/8Bo2V1xEoPDLEAAAAASUVORK5CYII=', 50, 1023, 1800, '15|0', 0, 0, 'Дает иммунитет ко всем эффектам, затрудняющим перемещение');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4133, 'Скорость', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADTklEQVQ4jQXBbUxVZQDA8f/znHPPfYUL8ZKBCBFLdMzmEEKhKQtNPtRs+aG15Ydq1pfc2uxDrrXaWsaoNpaztnSuD9ZsrljSdMskIQLdMHUOCOiSBTdeIriXc86997w8p99PvHF3MtjECpW5RWLKwvIsNEPiuSa6GyNh1+A5MSwvRygeYTWfwQxJlgKNgpZEDwUuqZs/kUysI9UKRRVx7Ow6W6orKDPqObr/CEv/wOaqKpbdZbbt385yWDBjVHKw6wX0LXYGXa3SYN6iPDJHyLJ5eHszd6YvM3LNpCkPrdEkJZ7JslinyBnmrePv0D++ga3+Qw8VTNq21lNjpyilGMpqyS/Ms/OhHdR1RMj0X6O8KM7Schrl+cQ8mL37Izeup2nu3oLuxEPMTP1FhS7JmFEGzo+hwvDia4e4fPEsqfuQUmlEGBYE2Csw9OUoYx7sVB66VVijpDxJLF9BMRE6Wmuobe0iNT7JrZFVDCnIE9DcBWd632ZkeoJPv/+W43uO4ufz6GHfROIijAQiGqe2/kFSQ4P0nOwnJDVyyscR0PVMFYRvMzE3gBGGe+Pj7Ho0gSzWPf7NLrJgpcEQzIze5MNP+tEfiJGVUdalZHd3FY17dmO7C6RmIRqCicl7SCGQfsHB9rIsqN/xNgX8YYUZWYavZ22G1nJc9xTvDaTxjTpC4a3UVMPaKiQ3N7Dm6khfCVran6Dp8Q6ujA5z7N2LbAiIx2FR+VhAXkJF48d4QQ1tzXuRDriuhykE0tKjeCqK51Vxqu8ODuABTgG+6DvIcwdieAqEBi+/2suOba3sa6mmJHBxlUSumhq/3pjjo74LZB1wgIQBE2Ov0N1SxtlTb/L8Acj50H8Vzn11nsamdgwBds5CnLg0GHzwbCco0ASc64XDnXuJCgOEAs3HlZW8dOwbvhuEggavn3iMDa8aFa5H+jJKaec+kNBz+hC7ug4jSpNMTc0ydXuC4V9+Rhlhek6/T9uT4GlgRqqx9DjrjoeeVTaff3aShDtNwljnzMAFQo5HpdZA1AchH+G3H9K0P/0U2fI6kH8yb0Xwo+WkzBDiyKWrQbH6m3J1H9dcRemlFOwAZdlEpEBz8+SdAhlhkHECMnmXIJJkPhcwqcX4H2oeeSaDCLFVAAAAAElFTkSuQmCC', 50, 1023, 1800, '15|0', 0, 0, 'Увеличивает скорость передвижения');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4132, 'Ловкость', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADJUlEQVQ4jQXBzWscZQDA4d/MvPO1s5tMkt00qQlNWZPUGmoQS9oqFltUbCNS0LYK4n/goSD1Ih71Jh69ilDQo2ARsWhoRG1KY9jakjRt2uxqvszO7CQ73/P6PMrnf2zJXHdQOiF9acSQGqAlO8Syy75q0WQQXwqM3KdX7aIn20hV8B8VtlIDYYQ5Vy59wJlzr1CJPcb0jFPPPMW/q78zWD/C47UUT7OZfe04auEzOtKDFCY3lzepiV7EWOJQ9iTvHx/n4ptn+PLTLyi1E047Fk9u3+DD19+jU7Y5cWIQRe+nKAr8SFJIjd+WHqLqaZd3z88wYmyz8OPX/PT9deZ+WaDSU2OyXqdXSzh1egbVkiiRRxbsYKoZE/VRDJkh8tIOFy4/xyHrHn8vLPH25bdAdVlxFV54/izV6WmIu+DHMHAYEx+hGJToI+hmiHYW8MO315iddLl76zHDE9O8ceE8lu1TfXaUImijOjboAoIAehxkArlhkUmBSNQK3/3cZHFO46Vjs5ydfpFeM2Ro4iB4/6DaFkQeyAQMC0KDLAStX9BNMlQZR3z28VWy3Zi7txpkUYeh+hBkIbgVZBGTG4CpQVEQdhJS1SHMoCgKRDXtYIbLfHN1ijTc5/AhDchAN4nyEByTSIa4Sg+J0NmSkkIzUDMo5TlCSTyaK7/iRPd558pHUK9DSbC/H4ChkCFBMdnLJbpmohsZFDmLN+cxum2EaWe8fO4kx9QaGD5xu0mOiePYIHNAI4wTdLMMScpwskdr7RHDBJRjD5GmGbYzQBG12Gw0OPDqSdBjKArwPbAs7HIJkjbe2jLhagOSCFWrkCa7iDiyuTH3Jw+8BjPTYxDuQuqBNEHRQLjgbYBT4HYXWZ//iv7hcfbco8RlgYiNGvN3WoxOjdNRKjy6f4+RqUmUTEFYJRCS3eYDWiu3GdISqtVBnmy0uL7YZq0yhlgvHDbdA+RPj9Mqh6xbA+wbVTrNbRJ/m1qtRHujTXPVwz56hCW/SaOV89eujuoeRPnk2h1pIOkLm3TjbVpmSpcCIwAzSxEyQo/36E0Tun5ApEoSo0yzA23b5X90snmzbGqpJgAAAABJRU5ErkJggg==', 10, 1023, 1800, '15|0', 0, 0, 'Увеличивает скорость атаки');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4118, 'Реген HP', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADR0lEQVQ4jQXBS2gcZQDA8f9889yZ3U0276Ru2q4hjTXVYF+a0jZQraDQKiWgeFJRQdTYeCqCCILiQfEQ8Kp48HEotXjpQSFS6SOR1qQ0VZu0SbskTUx2k81mZ2fm+z5/P+PMVFlnN0v0hlukojrr0kAZ4BoKM4kQYYhvKOJqiOU7lIViVdgs4lNSNnxysajpHtRD2wb14VSP/vHrn/StmaK27Radsdv0K0PDevLbC3r04LB+vf9Z3e/ndeC0a1r26NNnJ7Q1UIs5IWxetm2chiYGFuYoLG1nPxGxTDj18A72PrabP1eKeGie6+3hVqnMX2ZAvlhE5MKQgSCgs7TBAd+jIDSQYMUbtOuE2SuXoFLmzbdfo3F9hezcHfZZHruk4iGpECpJeLyvjyDrk2lrhs4O3j9+nH6nlTYrYPzGJU4e2cPli7/St7cfG0FaGnS3tKMqW1iebaO1JrerwLW/pxg/PYLSmsAAKWO6M238W1nkq3PfkwFO5QooFLJeJ+W6iLBW5eb8HHc8zdjdSZaVIlIaR0paTB/PNdnZ3E6+M88ycDuqsZn2qFuSanUTsWUrdgzs5nrxHkuAIwIaRQZTJqhkE1WP8CyL64v38DCoeS5rtkY6JrGOEQ9MyeV/Zrgw+Tt9hk8DLmll0Wo3kzUDervyLD9YpAuTNlymVhd49NBTDBw+RKJiRFkrfrs6gS0sDj7yBB9/+QU5YRPFW3iGT1KVtIoUoy+8yqejHxKj+GjscyJbsFoPEa6XpiRr1FSdN959CwwJMiZjplFKY5kuoYq4MXGVjGOyr7EVG80P534m9FOI2to6TekcWcuFeIvx775BmBDrGDBxLA8NhPUaEDP84gliIBGwtllB5KSBlSQcOXqUdz4Y4cnnj9Gxs5uKqlLIb8dyTUIUTd3tkO/E9z16nBT378zhCYFIZxoJnYAN4dI39DRrmSznZ2+yrX8/Jd+llglIhMfZa1dIELQeGKSoFDXXpxpLxHS5wm08VrIdPPPeGV76bIzZdCfTmYCZbMC0khSOneSu2cQv8/+x0NLFfEMX982ApcTEGDn/h3ZlhVypSJBIoiiFbTio1RKeZVKTijAMEYmmltQp6yqhZVOJUiwlDv8DDEZzFZpBupkAAAAASUVORK5CYII=', 150, 1023, 1800, '15|0', 0, 0, 'Ускоренная регенерация HP');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4119, 'Реген MP', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAC3ElEQVQ4jSXSW4hUBQCH8d85Mzt7ZsY1JS9YtqyxRrUurpfW3VTMoAsYimAEBUVIDwlBEEIvlT7US09GED36EBJIF0h6yG3J1ZoVXRArNbUN8dLF2p2d2bmdmXN62Ofv4ePj/w+evxin7TTV3ZoThYlq3BHXKtb0BJL5unq7oJrmJNnI1XbDVD6m07azHFuZZGVnclknPz5KMeKXi+zd5b3dow6/foCvvmHFoEMnT/i09LM7YcqfN7h12/jl3/W/cUB4o5lS6CG3lIfXe3XvqHq5at+OEbTYsVXaYP/WAX4a485fPPAgfb2uNevCm52EDZtJuhjaoFnmx9Jpxw++zXN7OPmdw/t2K536lpEB4ha5PP0Pkc8LlOqpX+9QqxLM88khpi+zYjXD25ibY+o8/02TzfPKQdYNM1umv092cxQ5V6mixofvU73Jrt3kl9EJ6MzxxOPcXcXEOUpnWbmWbEgQCoNqi7jKpSlaZXY+TfcSMsWFrMJiGh0yOQYGuHcVzTZBQL0qXNNp8sclPjtK3FiAmQLNhFyBJKQeU+5w5SbXrpPFfIV2U9jbKXPic5YW+egIg0PMVlndy33309fH7bvs2MP+N3l0LaUfKGTopMKgNktzjmLk2e2jvPTCguHKFeImaUq+h1ps31uvsX2UMxOcO09lTtjKZokWMbpF3I0ooV0haJBBmiHXRU/g+NkptjxGcRH/zhBlhGFXRDXmqWeMvfMuF0qMDC7YNw4RddNu02kSIcowPERPD7WGcLYSs/dFuWw3ExNcmKR8l5ERsjkWF1mxhOnrxC0jvcv55za/XaXeFqZdOcZOy9UTH5TGOTPJsWMMPIKATZsYXM/EJJnAmkUB2zYStIlj4UySEMeq4yW5MtLCwhKtGklr4QtbniTttmw+Nv79mP7hdY6c+oIwFrz89XRabnNPo6oYV2Q6M24FiS87EYuX0+pivsb8DJkm9b9JO1RCgrz/AdanN9aRxY2fAAAAAElFTkSuQmCC', 150, 1023, 1800, '15|0', 0, 0, 'Ускоренная регенерация MP');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4120, 'Наполнение', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADaklEQVQ4jQXBW0xbdQDA4d85/Z+2tECppaXcOhi3MYSxZCy7MLMIZBM3L3EucQteQrI3NTEm+rKY6OM08UlfMMYH9+JlJgxjxvawDSJbYOAyITgKA0YpFOi957Tn9By/T/r6n1mrLLNNiyRRyGTZEw5MScGdLeK0yeTMPCk1jcftwshmsVsGuSIkRDmrshtRLLj45cdR3mqtZvbBJCeG3uPP8Xv4VIuxX2/Q0N3GwEAf12+Pc66/j43FJ0STGuPrGpevfoWo1tJcaqmhKbWCkyjJ0RGaMwUe3JqgUZYYOvkGx7r2EUq3MfXbCIea91NMpWmyedHjcYTQsriKGarlHGvbC7w5+CH1A6/yvbhK3jQZ/ugK5PPM3xsn4FYIT98nLtnB3YHTZUNILgeWQ2F2ZppAXZD6vpfBU86GmuGPm4+4OddL76kBEs+es7a8yukXGwi4PTxaVtlUE4hMRiUX20GPRmjqOcw3n37OVlFBcXvIAJ7KOv6emmV5fo32F+w8C6+glUicH/yApN1AttsEka0owdr9ePyN/HxjjtG/prFw4pQk5h4+ZWF+HdWQKC3xIjSLi2f6OHukDSv2H7JiWNQGq4hE1tmKRbj+wzVM3UJSU7z9Wi9X3jlHV70fryzREQpx6fV+OuuClKhx/FIeoegmoZoq3J3tlAuDAzXlfHzxOLJTY/j9YWSphJOtdXz5xXdUKlm6u4+ArLO4tY6jWIlsYWGzWfS/e5nOgy0szUxSVswxfWeGxw8nsBkqLiuPy4KzfS8RW3oCAhqbWjEMHZExNXqOdsHeYyhz0FxzgIW5edxC4t/ZJex6BcJwIABDzyE57axurDKh7rBp+hCabrC7FyOgpnl6fwy/7yDnhy7QfKyDa9/+xPb2OlOTm3zy2QVUKUVFuQNDUsipDkSpD2nk91uWWB6jubDI4WAJeq6IJ9QAQS9UeomHV/D6/OjpLPHocwIVHpJZwe01G3fjTuSC6SAneYhaHlxHB3E2HmLHFNBznE1Ng4Z6aGsiV+UjcOo0NLVj+EJ0nhggnisgkpad+tZeXKKDu+EEnS2vUFlbRcICq30fiVyStGwRURRa/XWYsV3SfpPFcBoDB6IxrSB2JbKWSUaHO4szyE5BOBlDckvoxQTFokZBg1t5CyWVxG0rJZUvpdS08z/RQHk2tebUbwAAAABJRU5ErkJggg==', 34, 1023, 1800, '15', 0, 0, 'Увеличивает максимальное значение здоровья');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4126, 'Внимание', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADNklEQVQ4jSXDW0zVdQDA8e/vfz38kdM5QG44IMBkDC84hs1WOVJbt0X2lD1FrZW2XiJ1PbUeoq3Vopa6uelsyxVdrK2l5HZQEPFAnQKxIHDByGaRcW6c/znnf/v9e+izfcSRqeVQC13ivo9eLhPxJHooUaRACEHRLVGSIZ5mIYWJKEJZetiWR67kogV6hPaNjWwwQQ/A9uFCYobd920jMTrNsQN90NkJJQHChNgGWFcJgx/z4NkzKEYmR2sELAcsD5Lnh7n6/Tc8tWkHvd3bUe9qheTPMPkjahCwDYW2gk/F/heJ/RuiGIR4gCkgZkL/ywcxnCLgc+XCBB8e6YNCHpwMQWqSmdFhDCdHTSFPXChonlBZzYOiQGAD9W1Mzy9hNddz9PgHfDU4yM6eh9DNCGtrNtOXrjIzdBKEjnhyFwqqzuWJOQ6++j7jlxc49vZ7lK6METdNfh8b4pUDL+HbNmNffkqFDrWN1RBRQcnjeTnEa4m58NR3CbJnzoNm0PPME3Tf20Hf04+AaoIUKHoU6eVASJBFUFRQBM8e/QTFMOPsu38vVNWCiPDtwADvDHzEc4ffoKmjE1CQXgGE9v/QB+lAGFK2PZS0bZC69ieH3nwL0nkQISuTY5x+t5+GhiYe3befrgd2E6urB2mDUEFYUN2GEkQRvYlCODR0kX9mf+Ox9rtZXJplbmIUbi0CEtQYBFnQFMClZftWInfUEMbrqN+yC+0meWJVkpXkGOcuXqK152FauvYQ1x5n6cYid0ajlF2b5ub1hGqZfPpvpq79BOlR6u7ZiVb0beZTSehsh6l5Fs5+DVYNeksTtZFKyj4YFVWMjKTg9hLggqpAdD2rjo22KWKRHBlnz/MvENm8mXPHT4Cbw/s1yV+hD6GEUCI2dqJaXTRWVRPoCstOBl1Wodm5PLgOwydPsbe3l9dPn2B8MsUP169jCdBUgaEZ2KUAS1TiFSQ3M6tQEXLDXkMzUaFjKxRtEl98RuKXWQ71HWbLjm6mZ+dYya7gyjLZP5bJhiXwXGjQIH2LnL6G6P98IQyKDr63BtKHwKDkAKKSYqmM72XR9IBCMQcECM/Flx4Z2+b2Oo3/ADtZbrw8PPftAAAAAElFTkSuQmCC', 50, 1023, 1800, '15|0', 0, 0, 'Увеличивает уклон');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4125, 'Опека духов', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADAElEQVQ4jQXBv28bVQDA8e977+58ts+OHTsUmzakSVMalRKSUgFTo0qIhS2MLDAiBhArE/8ASwULosCEWJhQ+LGkqAHBQFUR6tBfqUlworj2+dfd2Xd+7/h8xI3feqmcxOTMGNuMkUmEqzVZbfDGCbUxTMMuI9vHLmbod0OGaZagdJq9RGDtWykfX7sG0z4YH/SYjHLQOmbjqQvUuwGX5mYxmYj/em1ip8h9rbiV5nj/+qdYc/EAxv+SFyEXMiluoommUzxg9cldNt0K80/62JmEkWPxR+eANFU8yp3C00OscjIhoxwq0wGFCM4VQaRwagbmfEN9pk21BxkB3gg8DfPCRkVtnPEQyxoaztkzvOR0KaSG8+vwzgcvkl88A+UytHz4c5/+9V2yQlDak1hGYZkJcjjAmrUFBSZYiWFjAzY/exusfXA7ED3g4XaDmQ5Ur0Ln1xQpDOiE57wSdSWQRG0ydgftwOaHbwEBZHMwtfj96wZLK1Bdh/sNqLxa53zNY9Ut44YDciMfKTAoN+XiVaDQ5/jBt2COgYCVFyA1wOoai2vA8lniJCBjJSzVT6N1jBVMJAOhePnNDZg3PF2+CM4xBB7FZyDYhXzjNmoZuLtDZXkW2YRRXtJGI1U+x5EfIvMu5ASYLgQtIITlK+QrQBse3oZhAsoz3Gl2GfT7BJMY6ScdnKJg+/sfoCchrvPzFxAcHoIWYAMZWFqHwiz4QQ9HgDeWeGONRElkLNj+BvxfmhAu8Nplm3ztdYhy3NsCHgMTIFuj0YQ0K4mMQ5IopBlZVNUCi7bgk/fuwE4I/ctw8x5HX26jBnDwN9C/xNZXR9xqws3AsNPr0rayWJGb5yAQLKoq7rTNR+9usbIGz7+ygKXO4psWrjPHjzf+YvcxnBhoySy+KnGMxNq1E1o5+Gk05UrpDPa0zV5D8/neAYmAsKdxxREyUbhejmhs808c0VWKZpoi3vhuJ33WltRODqnGIUoHRFFAIFMmTAHNcBTimDxG24T9CYHtcKJcHgH/A80RWlqALp0iAAAAAElFTkSuQmCC', 60, 1023, 1800, '15|0', 0, 0, 'Увеличивает маг защиту');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4165, 'Святая сила', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADL0lEQVQ4jQXBy2scdQDA8e9v5jc7j91xkzQmG5vUWNMYIVoFDYpgRdCDWkEQtQSt0oOCCF579eIf4MWbIOKhSJXWHioeSmOjJVrTJDYxzcOmeexm36/ZnZ3fzM/PR3y50NZ1M8SvN8lZAtks45kJIomJoxClEoTQmCKhrUJ6tkU+DKlako7wkG475PwHb0H1ANIamvuIsMOzT07x0ewZMr5LoFqMTYwydjTH0Ng4vyws88XX33LuvY+RY2YXDtY4kk6Rqh7SikIGDXgiqjNeuYejBT03Ynp8iKaxTQ6Lwh+XmawUGQ1CpOpUyT00wPGwhB0n5HvgxOC1yuwvX2d4wiE97iBI42CwcmOBQV3g7OunSDpFjMhS9GU0fq/KmKc54ZqMSEHWz1Bp73DQWOLF107g+YfMXfuKw7s/MTM9hCnz9IwiRhj3MOnwyEiajEhwYrCEYP1+iatzXYanwHigy9qdi2wuwv3lBoV/19lauY2lYwxbCBxDkEpFGCS0VUygE/IhPP4qvPTO+zSiLnurMTMPZ7DqgvX5Azb/3kV2JYYII46NHMX1LbwHQdig00AfnJ59nliW2dq4wlOTJ8mofrZuaQobB8xMPoPR7CHtQFOr1KkYdaQENQBOH5w9B8cn2txd/J2sA3ZU5vb8LoM+ONk+amELT0VI04qwnJA3T7+BEW9wY3WNDz95Gy0KWHGNnJ1m7kqb0sYuAwJIQ8pNEaAwdYjcM3b47Pwsj6p7ZKXLYy+c5M9bc/xzc59TT0+wdK3N4SbQgvFpH2kG9IBmp02sykjtCu6sr3Phm+/pM+Dld6dIlIdnwsJv22z+BaIB/TY0ihaj/SNEwibUJkkiMKKWSa3m0QmgUoJfL63h6lGSeJT5mzGJYxJZBm7WpdDosrXXYLvUo9qzaMUeEiNLxxrilTOf0q/b/Hj5Oy5dXWRltYaKQLs+dlaxh8ANDfJRipoyWQ0CJs00stwT5KafI2nnMS3BcD7kwg8X0fYRAiumhKA/k8aLFBmZpVXXLO0UCTI+vrIRn/98XQfBfxxLRVAtIiONihOCOKEbJ+goQSrQQQcVCRQulRhKQpBPFP8DsPmEUMpjd3QAAAAASUVORK5CYII=', 40, 1023, 1800, '15|0', 0, 0, 'Увеличивает силу физ атаки');
INSERT INTO `shop_buffs` (`filter_id`, `name`, `icon`, `value`, `class_mask`, `expire`, `cost`, `enabled`, `buy_count`, `description`) VALUES (4164, 'Стальная аура', 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADLUlEQVQ4jSXRy29UVQCA8e+cc+/M3NvpzNR2TAlCUoX6SGC0GK2JLEishqixKIkhUZdoXOjG6IIYVxg1aNJIYowiKnEllQo+YqgseLSitLU1PKRAixFsOqWdmU5n7r3n3nNc9B/4Fr9PvDs6b2/kI/L1fynKGuloAWsCEtdjMTCskCbR4CuHKGyiFNQTl7ItUDUtyE6nwddHPmHsyEfI2WE6li9QWJ4lmZumLWlwYP+HrFz8k0eLPv6V32n95yT+zZNcPnuU1riKo+qX6LVX6N+aZo26ihdkiOM2Dh74keHhGbDw6dAo3e+9wlNbu6mbKcaunue2ZUFHYwticORbO10+w52ZS6SWF/j73C0+HphhQYNRkBiwBtICfAn79nexoedhTl9wqahepI5qrG3P0unlqc9FvPP+DEsRGANxBCYBgBioatj71gzRvEtne5ZmUkU6Fq5PT0NTc/ibKTwHIrMaKN0n+eLgDnbugtiAEBA3YOK3CfItOUzcRNqmwDYl2YxPpKFpAQlSQf8zJZ5/7h6e6CsiFVhg2+OwqfQQJnCRiUA6boYN95YYm7zG3g92s+eNB3hwE5Q2QiE1gWem6ciU2fUsfPn507y4+3U+OzSItT61IMAJiVCFIoeO/sHPx0Z4YWc/978s6NveDcll/ps6TO862PzaHdQSyatvDjAyCT39NZKUh1NvVCmqNoxcx7Hj1/jrzBD92yGTHuexvh5aFSQxYF32vP09Z8+BtZDz8+ilKk5rSpFHogKFsJDx4IdfVtWVGad0N5igwKlTtzhxchUSIK812SBGNgJNI7R4bitKwEINhAOnT4AbbSSddJJNdTH8U43Qrt5JeRA0Q5phgqNT7YzPlqmGmhZXshAZKhXoBO7KrUfM/4oWDl4aUgJcKQgCy3wkmfM8nOWkhYoMGZ24iItECwvSsmWzwHhrcVOPEISKucYNFq1FJwIcRcWkOb9SwVkJPfZ9NQQqi1YuJA20iOh68iUmmznWyxTW8enatgY99R14t0OzhlYFpDCIgcHjdiZYImcMOogIpU8crZBPbpLTZfxgkUjDkixSTrLMNRRGSdBVrqP4H5tAdjx7wXUmAAAAAElFTkSuQmCC', 75, 1023, 1800, '15|0', 0, 0, 'Увеличивает физ защиту');
ALTER TABLE  `users` CHANGE  `bonus_data`  `bonus_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
CREATE TABLE IF NOT EXISTS `promo_codes` (`id` int(11) NOT NULL AUTO_INCREMENT,`code` varchar(50) CHARACTER SET utf8 NOT NULL,`expire` int(11) NOT NULL DEFAULT '0',`bonus_money_gold` int(11) NOT NULL DEFAULT '0',`bonus_money_silver` int(11) NOT NULL DEFAULT '0',`bonus_item_id` int(11) NOT NULL DEFAULT '0',`bonus_item_count` int(11) NOT NULL DEFAULT '0',`bonus_item_max_count` int(11) NOT NULL DEFAULT '0',`bonus_item_data` varchar(1000) CHARACTER SET utf8 NOT NULL,`bonus_item_mask` int(11) NOT NULL DEFAULT '0',`bonus_item_proctype` int(11) NOT NULL DEFAULT '0',`bonus_item_expire` int(11) NOT NULL DEFAULT '0',`multi_user` tinyint(4) NOT NULL DEFAULT '0',`used_userid` int(11) NOT NULL DEFAULT '0',`desc` varchar(500) CHARACTER SET utf8 NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `code` (`code`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
ALTER TABLE `klan_items` ADD `remove_no_klan` TINYINT NOT NULL DEFAULT '0' AFTER `cost_item_count`;
ALTER TABLE `promo_codes` ADD `group` INT NOT NULL DEFAULT '0' AFTER `expire`;
CREATE TABLE IF NOT EXISTS `klan_pic` (`klanid` int(11) NOT NULL, `servid` int(11) NOT NULL DEFAULT '1', `pic` blob NOT NULL, KEY `klanid` (`klanid`), KEY `servid` (`servid`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `shop_skills` ( `id` int(11) NOT NULL AUTO_INCREMENT, `skillid` int(11) NOT NULL, `name` varchar(50) CHARACTER SET utf8 NOT NULL, `kind` tinyint(4) NOT NULL, `icon` varchar(50) CHARACTER SET utf8 NOT NULL, `cls` int(11) NOT NULL, `max_lvl` int(11) NOT NULL, `class_mask` int(11) NOT NULL DEFAULT '1023', `cost` varchar(34) NOT NULL DEFAULT '10', `enabled` tinyint(4) NOT NULL DEFAULT '0', `buy_count` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`id`), KEY `skillid` (`skillid`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1, 'Удар тигра', 0, '虎击.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(176, 'Вздымающаяся волна', 0, '凌波微步.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(177, 'Сутра о внутреннем', 0, '易筋经.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(178, 'Сутра о внешнем', 0, '易髓经.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(179, 'Воин Будды', 0, '金刚经.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2, 'Глубокий порез', 0, '寸力.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(226, 'Вспышка ци', 0, '爆气1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(227, 'Высшая вспышка ци', 0, '爆气2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(3, 'Зарождающийся шторм', 0, '凌风.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(4, 'Львиный рык', 0, '狮子吼.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(5, 'Стремительный дракон', 0, '龙现.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(54, 'Вздымающееся море', 0, '流水.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(55, 'Яростный дракон', 0, '狂龙斩.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(56, 'Разделяющие удары', 0, '横扫千军.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(57, 'Расколотая гора', 0, '断岩斩.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(58, 'Парящий дракон', 0, '龙腾.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(59, 'Прыжок тигра', 0, '虎跃.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(6, 'Техника боя с мечом', 0, '刀剑精通.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(60, 'Расколотое небо', 0, '劈空掌.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(61, 'Удар без тени', 0, '无影脚.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(62, 'Очищение небес', 0, '风卷残云.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(63, 'Удар дракона', 0, '云龙九现.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(64, 'Буря шипов', 0, '疾风霹雳.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(65, 'Самозарядная пушка', 0, '回马枪.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(66, 'Падающие звезды', 0, '流星赶月.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(67, 'Морозное сияние', 0, '刃域.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(68, 'Летящий дракон', 0, '霸王龙飞.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(69, 'Гнев небес', 0, '天火狂龙.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(70, 'Удар лавины', 0, '霸王断岳.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(71, 'Ревущая гора', 0, '霸王暴怒.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(72, 'Удар пустоты', 0, '忘情式.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(73, 'Призрачный охотник', 0, '追魂诀.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(74, 'Дух меча', 0, '剑气纵横.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(75, 'Десять тысяч лезвий', 0, '万剑诀.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(76, 'Гуляющий ветер', 0, '疾云步.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(77, 'Аура стали', 0, '金钟罩.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(78, 'Техника боя с копьем', 0, '长兵精通.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(79, 'Техника боя с молотом', 0, '斧锤精通.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(80, 'Техника боя с кастетом', 0, '拳术精通.dds', 0, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(896, 'Драконоборец', 1, '狂龙之力.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(897, 'Массовая атака грома', 1, '雷霆震击.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(898, 'Пике', 1, '剑啸长空.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(923, 'Вспышка', 2, '一闪.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(924, 'Алмазная аура', 2, '金刚气.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(899, 'Вспышка', 3, '一闪.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(900, 'Алмазная аура', 3, '金刚气.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(363, 'Вспышка демона', 4, '魔元爆发.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(375, 'Темный удар тигра', 4, '虎击2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(377, 'Темный глубокий порез', 4, '寸力2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(379, 'Темное вздымающееся море', 4, '流水2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(381, 'Темный зарождающийся шторм', 4, '凌风2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(383, 'Темный стремительный дракон', 4, '龙现2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(385, 'Темная расколотая гора', 4, '断岩斩2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(387, 'Темный яростный дракон', 4, '狂龙斩2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(389, 'Темные разделяющие удары', 4, '横扫千军2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(391, 'Темное расколотое небо', 4, '劈空掌2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(393, 'Темный удар без тени', 4, '无影脚2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(395, 'Темное очищение небес', 4, '风卷残云2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(397, 'Темный удар дракона', 4, '云龙九现2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(399, 'Темная буря шипов', 4, '疾风刺2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(401, 'Темная самозарядная пушка', 4, '回马枪2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(403, 'Темные падающие звезды', 4, '流星赶月2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(405, 'Темное морозное сияние', 4, '寒冰刃域.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(407, 'Темный летящий дракон', 4, '龙飞击2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(409, 'Темный удар лавины', 4, '断岳扫2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(411, 'Темная ревущая гора', 4, '裂岩炎震2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(413, 'Темный гнев небес', 4, '天火狂龙2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(415, 'Темный удар пустоты', 4, '忘情式2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(417, 'Темный призрачный охотник', 4, '追魂诀2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(419, 'Темный дух меча', 4, '剑气纵横2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(421, 'Темные десять тысяч лезвий', 4, '万剑诀2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(423, 'Темная аура стали', 4, '金钟罩2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(425, 'Темный львиный рык', 4, '狮子吼2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(427, 'Темная сутра о внутреннем', 4, '易筋经2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(429, 'Темная сутра о внешнем', 4, '易髓经2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(431, 'Темный воин Будды', 4, '金刚经2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(433, 'Темная техника боя с мечом', 4, '刀剑精通2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(435, 'Темная техника боя с копьем', 4, '长兵精通2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(438, 'Темная техника боя с кастетами', 4, '拳术精通2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(439, 'Темная техника боя с молотом', 4, '斧锤精通2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(362, 'Вспышка бессмертного', 5, '仙元爆发.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(374, 'Светлый удар тигра', 5, '虎击1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(376, 'Светлый глубокий порез', 5, '寸力1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(378, 'Светлое вздымающееся море', 5, '流水1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(380, 'Светлый зарождающийся шторм', 5, '凌风1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(382, 'Светлый стремительный дракон', 5, '龙现1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(384, 'Светлая расколотая гора', 5, '断岩斩1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(386, 'Светлый яростный дракон', 5, '狂龙斩1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(388, 'Светлые разделяющие удары', 5, '横扫千军1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(390, 'Светлое расколотое небо', 5, '劈空掌1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(392, 'Светлый удар без тени', 5, '无影脚1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(394, 'Светлое очищение небес', 5, '风卷残云1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(396, 'Светлый удар дракона', 5, '云龙九现1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(398, 'Светлая буря шипов', 5, '疾风刺1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(400, 'Светлая самозарядная пушка', 5, '回马枪1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(402, 'Светлые падающие звезды', 5, '流星赶月1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(404, 'Светлое морозное сияние', 5, '寒冰刃域1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(406, 'Светлый летящий дракон', 5, '龙飞击1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(408, 'Светлый удар лавины', 5, '断岳扫1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(410, 'Светлая ревущая гора', 5, '裂岩炎震1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(412, 'Светлый гнев небес', 5, '天火狂龙1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(414, 'Светлый удар пустоты', 5, '忘情式1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(416, 'Светлый призрачный охотник', 5, '追魂诀1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(418, 'Светлый дух меча', 5, '剑气纵横1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(420, 'Светлые десять тысяч лезвий', 5, '万剑诀1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(422, 'Светлая аура стали', 5, '金钟罩1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(424, 'Светлый львиный рык', 5, '狮子吼1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(426, 'Светлая сутра о внутреннем', 5, '易筋经1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(428, 'Светлая сутра о внешнем', 5, '易髓经1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(430, 'Светлый воин Будды', 5, '金刚经1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(432, 'Светлая техника боя с мечом', 5, '刀剑精通1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(434, 'Светлая техника боя с копьем', 5, '长兵精通1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(436, 'Светлая техника боя с молотом', 5, '拳术精通1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(437, 'Светлая техника боя с кастетами', 5, '斧锤精通1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1815, 'Таран', 6, '霸气.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1816, 'Пустота - Кара богов', 6, '狂风.dds', 0, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1817, 'Ударная волна', 6, '碎颅.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1818, 'Разгром', 6, '回旋击.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1819, 'Драконий аркан', 6, '龙依.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1871, 'Кара богов', 6, '狂风.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2207, 'Демонический взрыв гнева', 7, '荒·虎崩.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2209, 'Демоническое сокрушение', 7, '荒·千军辟易.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2211, 'Демоническая неукротимая буря', 7, '荒·断水凌风.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2367, 'Демоническая самозарядная пушка', 7, '回马枪2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2369, 'Демонический призрачный охотник', 7, '追魂诀2.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2371, 'Демонический крушитель небес', 7, '荒·劈星斩月.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2373, 'Демонический удар лавины', 7, '荒·破山.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2375, 'Демонический гнев дракона', 7, '荒·升龙破.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2206, 'Божественный взрыв гнева', 8, '玄·虎崩.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2208, 'Божественное сокрушение', 8, '玄·千军辟易.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2210, 'Божественная неукротимая буря', 8, '玄·断水凌风.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2352, 'Божественная самозарядная пушка', 8, '回马枪1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2368, 'Божественный призрачный охотник', 8, '追魂诀1.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2370, 'Божественный крушитель небес', 8, '玄·劈星斩月.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2372, 'Божественный удар лавины', 8, '玄·破山.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2374, 'Божественный гнев дракона', 8, '玄·升龙破.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 0, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(10, 'Ускользающая земля', 0, '沙陷.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(100, 'Сдвиг земли', 0, '缩地术.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(101, 'Знание стихии земли', 0, '土精通.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(180, 'Ледяной доспех', 0, '寒冰护甲.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(181, 'Земляной доспех', 0, '奇门护甲.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(182, 'Ливень', 0, '冰雹.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(183, 'Сутра о душе', 0, '般若心经.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(184, 'Несогласие', 0, '石破天惊.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(228, 'Вспышка ци', 0, '爆气1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(229, 'Высшая вспышка ци', 0, '爆气2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(53, 'Знание стихии огня', 0, '火精通.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(7, 'Пламенный фонарь', 0, '火煞天灯.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(8, 'Жертвоприношение', 0, '血祭炎爆.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(81, 'Огненное клеймо', 0, '烈火符.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(84, 'Крылья феникса', 0, '烈火炽翼.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(85, 'Священное пламя', 0, '神火符.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(86, 'Огненная буря', 0, '炙炎阵.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(87, 'Огненный ливень', 0, '火海刀山.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(88, 'Бьющий ключ', 0, '涌泉.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(89, 'Сосредоточение', 0, '润泽.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(9, 'Знание стихии воды', 0, '水精通.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(90, 'Утренняя роса', 0, '寒霜.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(91, 'Обморожение', 0, '霜刃.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(92, 'Смертоносный град', 0, '凌杀.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(93, 'Ярость водного дракона', 0, '玄冰水龙.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(96, 'Огненный доспех', 0, '烈焰护甲.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(97, 'Камнепад', 0, '落石术.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(98, 'Песчаная буря', 0, '飞沙术.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(99, 'Сила гор', 0, '泰山压顶.dds', 1, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(902, 'Атака земли', 1, '土灵击.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(903, 'Усыпление', 1, '摄魂之力.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(904, 'Яростная защита', 1, '真元护体.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(925, 'Превосходство духа', 2, '气贯长虹.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(926, 'Гнев стихий', 2, '灵气震爆.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(901, 'Превосходство духа', 3, '气贯长虹.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(905, 'Гнев стихий', 3, '灵气震爆.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(365, 'Вспышка демона', 4, '魔元爆发.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(441, 'Темное огненное клеймо', 4, '烈火符2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(443, 'Темный огненный доспех', 4, '烈焰护甲2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(445, 'Темный пламенный фонарь', 4, '火煞天灯2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(447, 'Темное священное пламя', 4, '神火符2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(449, 'Темная огненная буря', 4, '炙炎阵2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(451, 'Темные крылья феникса', 4, '烈火炽翼2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(453, 'Темное жертвоприношение', 4, '血祭炎爆2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(455, 'Темный огненный ливень', 4, '火海刀山2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(457, 'Темный бьющий ключ', 4, '涌泉2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(459, 'Темный ледяной доспех', 4, '寒冰护甲2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(461, 'Темный ливень', 4, '冰雹2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(463, 'Темная утренняя роса', 4, '寒露2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(465, 'Темное сосредоточение', 4, '润泽2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(467, 'Темное обморожение', 4, '霜刃2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(469, 'Темный смертоносный град', 4, '凌杀2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(471, 'Темная ярость водного дракона', 4, '玄冰水龙2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(473, 'Темный камнепад', 4, '落石术2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(475, 'Темный земляной доспех', 4, '奇门护甲2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(477, 'Темная ускользающая земля', 4, '沙陷2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(479, 'Темный сдвиг земли', 4, '缩地术2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(481, 'Темная песчаная буря', 4, '飞沙术2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(483, 'Темное несогласие', 4, '石破天惊2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(485, 'Темная сила гор', 4, '泰山压顶2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(487, 'Темное знание стихии огня', 4, '火精通2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(489, 'Темное знание стихии воды', 4, '水精通2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(491, 'Темное знание стихии земли', 4, '土精通2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(364, 'Вспышка бессмертного', 5, '仙元爆发.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(440, 'Светлое огненное клеймо', 5, '烈火符1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(442, 'Светлый огненный доспех', 5, '烈焰护甲1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(444, 'Светлый пламенный фонарь', 5, '火煞天灯1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(446, 'Светлое священное пламя', 5, '神火符1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(448, 'Светлая огненная буря', 5, '炙炎阵1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(450, 'Светлые крылья феникса', 5, '烈火炽翼1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(452, 'Светлое жертвоприношение', 5, '血祭炎爆1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(454, 'Светлый огненный ливень', 5, '火海刀山1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(456, 'Светлый бьющий ключ', 5, '涌泉1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(458, 'Светлый ледяной доспех', 5, '寒冰护甲1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(460, 'Светлый ливень', 5, '冰雹1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(462, 'Светлая утренняя роса', 5, '寒露1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(464, 'Светлое сосредоточение', 5, '润泽1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(466, 'Светлое обморожение', 5, '霜刃1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(468, 'Светлый смертоносный град', 5, '凌杀1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(470, 'Светлая ярость водного дракона', 5, '玄冰水龙1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(472, 'Светлый камнепад', 5, '落石术1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(474, 'Светлый земляной доспех', 5, '奇门护甲1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(476, 'Светлая ускользающая земля', 5, '沙陷1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(478, 'Светлый сдвиг земли', 5, '缩地术1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(480, 'Светлая песчаная буря', 5, '飞沙术1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(482, 'Светлое несогласие', 5, '石破天惊1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(484, 'Светлая сила гор', 5, '泰山压顶1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(486, 'Светлое знание стихии огня', 5, '火精通1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(488, 'Светлое знание стихии воды', 5, '水精通1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(490, 'Светлое знание стихии земли', 5, '土精通1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1805, 'Мистический свет', 6, '法之奥义.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1806, 'Ледяной мир', 6, '冰晶世界.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1807, 'Пустота - Отпечаток места', 6, '静谧之术.dds', 1, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1808, 'Антрацитовое пламя', 6, '炙焰.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1809, 'Песочный оберег', 6, '沙暴.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1865, 'Пустота - Отпечаток жизни', 6, '静谧之术2.dds', 1, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1873, 'Отпечаток места', 6, '静谧之术.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1874, 'Отпечаток жизни', 6, '静谧之术2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2255, 'Демонический земляной доспех', 7, '奇门护甲2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2257, 'Демонический огненный доспех', 7, '烈焰护甲2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2259, 'Демонический ледяной доспех', 7, '寒冰护甲2.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2263, 'Демоническое обморожение', 7, '荒·霜天之刃.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2265, 'Демонический зыбучий песок', 7, '荒·沙瀑.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2453, 'Демонические лед и пламя', 7, '荒·冰霜烈焰.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2254, 'Божественный земляной доспех', 8, '奇门护甲1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2256, 'Божественный огненный доспех', 8, '烈焰护甲1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2258, 'Божественный ледяной доспех', 8, '寒冰护甲1.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2262, 'Божественное обморожение', 8, '玄·霜天之刃.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2264, 'Божественный зыбучий песок', 8, '玄·沙瀑.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2452, 'Божественные лед и пламя', 8, '玄·冰霜烈焰.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 1, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1100, 'Дух мести: наказание', 0, '反弹之魂.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1101, 'Дух мести: заточение', 0, '封印之魂.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1102, 'Дух мести: отражение', 0, '反击之魂.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1103, 'Дух мести: потрясение', 0, '击晕之魂.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1104, 'Цветение жизни', 0, '祝福加深.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1105, 'Вечное заключение', 0, '祝福削弱.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1106, 'Тревога души', 0, '技能抑制.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1107, 'Дух мести: отдача', 0, '技能反噬.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1108, 'Заклинание тьмы', 0, '激流术.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1109, 'Заклинание света', 0, '增防减攻.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1125, 'Проклятие души', 0, '增攻减防.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1126, 'Водный удар', 0, '法术冲击.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1127, 'Поток', 0, '激流术.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1128, 'Водомет', 0, '气爆.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1129, 'Оковы льда', 0, '冷凝术.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1130, 'Проклятие разложения', 0, '土崩.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1131, 'Проклятие тлена', 0, '献祭.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1132, 'Проклятые пески', 0, '扬沙.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1133, 'Проклятие духов земли', 0, '土灵.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1134, 'Кровавый прилив', 0, '水瀑术.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1135, 'Сфера жизни', 0, '魔法盾.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1137, 'Превращение в русалку', 0, '人鱼变.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1140, 'Душа прилива', 0, '水精灵.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1141, 'Сила воли', 0, '术士的意志.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1184, 'Знание стихии воды', 0, '水系魔法精通.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1185, 'Знание стихии земли', 0, '土系魔法精通.dds', 2, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1186, 'Вспышка ци', 0, '爆气1.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1187, 'Высшая вспышка ци', 0, '爆气2.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1204, 'Зов ветра', 1, '海风召唤.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1205, 'Кристалл света', 1, '结晶之光.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1326, 'Проклятие песков', 2, '沙轰咒.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1327, 'Ужасное проклятие', 2, '碎石灭咒.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1206, 'Проклятие песков', 3, '沙轰咒.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1207, 'Ужасное проклятие', 3, '碎石灭咒.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1199, 'Вспышка демона', 4, '魔元爆发.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1209, 'Темный дух мести: наказание', 4, '反弹之魂魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1211, 'Темный дух мести: заточение', 4, '封印之魂魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1213, 'Темный дух мести: отражение', 4, '反击之魂魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1215, 'Темный дух мести: потрясение', 4, '击晕之魂魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1217, 'Темное цветение жизни', 4, '祝福加深魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1219, 'Темное вечное заключение', 4, '祝福削弱魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1221, 'Темная тревога души', 4, '技能抑制魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1223, 'Темный дух мести: отдача', 4, '技能反噬魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1225, 'Темное заклинание тьмы', 4, '增攻减防魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1227, 'Темное заклинание света', 4, '增防减攻魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1229, 'Темное проклятие души', 4, '加深打击魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1231, 'Темный водный удар', 4, '法术冲击魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1233, 'Темный поток', 4, '激流术魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1235, 'Темный водомет', 4, '气爆魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1237, 'Темные оковы льда', 4, '冷凝术魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1239, 'Темное проклятие разложения', 4, '土崩魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1241, 'Темное проклятие тлена', 4, '献祭魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1243, 'Темные проклятые пески', 4, '扬沙魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1245, 'Темное проклятие духов земли', 4, '土灵魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1247, 'Темный кровавый прилив', 4, '水瀑术魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1249, 'Темная сфера жизни', 4, '魔法盾魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1253, 'Темная душа прилива', 4, '水精灵魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1255, 'Темная сила воли', 4, '术士的意志魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1257, 'Темное знание стихии воды', 4, '水系魔法精通魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1259, 'Темное знание стихии земли', 4, '土系魔法精通魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1198, 'Вспышка бессмертного', 5, '仙元爆发.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1208, 'Светлый дух мести: наказание', 5, '反弹之魂仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1210, 'Светлый дух мести: заточение', 5, '封印之魂仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1212, 'Светлый дух мести: отражение', 5, '反击之魂仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1214, 'Светлый дух мести: потрясение', 5, '击晕之魂仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1216, 'Светлое цветение жизни', 5, '祝福加深仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1218, 'Светлое вечное заключение', 5, '祝福削弱仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1220, 'Светлая тревога души', 5, '技能抑制仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1222, 'Светлый дух мести: отдача', 5, '技能反噬仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1224, 'Светлое заклинание тьмы', 5, '增攻减防仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1226, 'Светлое заклинание света', 5, '增防减攻仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1228, 'Светлое проклятие души', 5, '加深打击仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1230, 'Светлый водный удар', 5, '法术冲击仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1232, 'Светлый поток', 5, '激流术仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1234, 'Светлый водомет', 5, '气爆仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1236, 'Светлые оковы льда', 5, '冷凝术仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1238, 'Светлое проклятие разложения', 5, '土崩仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1240, 'Светлое проклятие тлена', 5, '献祭仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1242, 'Светлые проклятые пески', 5, '扬沙仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1244, 'Светлое проклятие духов земли', 5, '土灵仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1246, 'Светлый кровавый прилив', 5, '水瀑术仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1248, 'Светлая сфера жизни', 5, '魔法盾仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1252, 'Светлая душа прилива', 5, '水精灵仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1254, 'Светлая сила воли', 5, '术士的意志仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1256, 'Светлое знание стихии воды', 5, '水系魔法精通仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1258, 'Светлое знание стихии земли', 5, '土系魔法精通仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1820, 'Телекинез', 6, '风岩葬.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1821, 'Моральная поддержка', 6, '流觞.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1822, 'Яньфу - Темное укрытие', 6, '冥王乐土.dds', 2, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1823, 'Крепкая связь', 6, '复仇之魂.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1824, 'Призыв', 6, '冥瞳.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1875, 'Темное укрытие', 6, '冥王乐土.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2239, 'Демоническая песчаная волна', 7, '荒·洪沙葬天.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2241, 'Демонический яростный шторм', 7, '荒·怒海狂澜.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2243, 'Демонические оковы льда', 7, '荒·冷凝术.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2435, 'Демоническое проклятие души', 7, '加深打击魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2437, 'Демонический водный удар', 7, '法术冲击魔技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2238, 'Божественная песчаная волна', 8, '玄·洪沙葬天.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2240, 'Божественный яростный шторм', 8, '玄·怒海狂澜.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2242, 'Божественные оковы льда', 8, '玄·冷凝术.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2434, 'Божественное проклятие души', 8, '加深打击仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2436, 'Божественный водный удар', 8, '法术冲击仙技能.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 2, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(299, 'Жалящий рой', 0, '剧毒蛊.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(300, 'Железный рой', 0, '铁岩蛊.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(301, 'Обжигающий рой', 0, '炎蛊.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(302, 'Ледяной рой', 0, '凌霜蛊.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(303, 'Муравьиный рой', 0, '千蚁蛊.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(304, 'Рой камней', 0, '巨石蛊.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(305, 'Нашествие саранчи', 0, '万蛊食天.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(306, 'Стена шипов', 0, '荆棘术.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(307, 'Жизненная сила', 0, '强体术.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(308, 'Духовная сила', 0, '神辅术.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(309, 'Перенос души', 0, '移元术.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(310, 'Барьер шипов', 0, '荆棘阵.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(311, 'Гармония', 0, '乾坤互移.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(312, 'Обращение в лисицу', 0, '灵狐变.dds', 3, 3, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(313, 'Когти лисицы', 0, '妖狐击.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(314, 'Огонь духов', 0, '妖雾击.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(315, 'Хвост лисицы', 0, '妖缠击.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(316, 'Тень лисицы', 0, '妖魂击.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(317, 'Хитрость лисицы', 0, '妖灵击.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(318, 'Дух лисицы', 0, '妖煞击.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(319, 'Изгнание', 0, '驱逐咒.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(320, 'Проклятие уязвимости', 0, '残体咒.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(321, 'Проклятие слабости', 0, '弱魂咒.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(322, 'Проклятие истощения', 0, '碎灵咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(323, 'Мастерство пловца', 0, '水性精通.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(324, 'Звериная ярость', 0, '拳术精通.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(325, 'Знание стихии дерева', 0, '木系精通.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(326, 'Вспышка ци', 0, '爆气1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(327, 'Высшая вспышка ци', 0, '爆气2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(328, 'Приручение животного', 0, '驯服宠物.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(329, 'Оживление питомца', 0, '复活宠物.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(330, 'Исцеление питомца', 0, '治疗宠物.dds', 3, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(762, 'Наряд из цветов', 0, '妖狐附体.dds', 3, 3, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(910, 'Радужный паразит (облик лисицы)', 1, '彩虹蛊.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(911, 'Радужный паразит', 1, '摄魂.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(912, 'Безмятежность', 1, '不动咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1985, 'Темное обращение в лисицу (усиленное)', 2, '灵狐变2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1987, 'Темное обращение в лунную лисицу', 2, '狂蝶羽变.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(927, 'Магический парадокс', 2, '媚心咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(928, 'Заклятье оцепенения', 2, '化石咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1984, 'Светлое обращение в лисицу (усиленное)', 3, '灵狐变1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1986, 'Светлое обращение в лунную лисицу', 3, '真蝶羽变.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(913, 'Магический парадокс', 3, '媚心咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(914, 'Заклятье оцепенения', 3, '化石咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(369, 'Вспышка демона', 4, '魔元爆发.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(635, 'Темный жалящий рой', 4, '剧毒蛊2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(637, 'Темный железный рой', 4, '铁岩蛊2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(639, 'Темный обжигающий рой', 4, '炎蛊2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(641, 'Темный ледяной рой', 4, '凌霜蛊2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(643, 'Темный муравьиный рой', 4, '千蚁蛊2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(645, 'Темный рой камней', 4, '巨石蛊2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(647, 'Темное нашествие саранчи', 4, '万蛊食天2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(649, 'Темная стена шипов', 4, '荆棘术2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(651, 'Темная жизненная сила', 4, '强体术2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(653, 'Темная духовная сила', 4, '神辅术2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(655, 'Темный перенос души', 4, '移元术2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(657, 'Темное обращение в лисицу', 4, '灵狐变2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(659, 'Темные когти лисицы', 4, '妖狐击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(661, 'Темный огонь духов', 4, '妖雾击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(663, 'Темный хвост лисицы', 4, '妖缠击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(665, 'Темная тень лисицы', 4, '妖魂击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(667, 'Темная хитрость лисицы', 4, '妖灵击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(669, 'Темный дух лисицы', 4, '妖煞击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(671, 'Темное изгнание', 4, '驱逐咒2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(673, 'Темное проклятие уязвимости', 4, '残体咒2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(675, 'Темное проклятие слабости', 4, '弱魂咒2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(677, 'Темное проклятие истощения', 4, '碎灵咒2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(679, 'Темная звериная ярость', 4, '拳术精通2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(681, 'Темное знание стихии дерева', 4, '木系精通2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(764, 'Темный наряд из цветов', 4, '妖狐附体2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(368, 'Вспышка бессмертного', 5, '仙元爆发.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(634, 'Светлый жалящий рой', 5, '剧毒蛊1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(636, 'Светлый железный рой', 5, '铁岩蛊1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(638, 'Светлый обжигающий рой', 5, '炎蛊1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(640, 'Светлый ледяной рой', 5, '凌霜蛊1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(642, 'Светлый муравьиный рой', 5, '千蚁蛊1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(644, 'Светлый рой камней', 5, '巨石蛊1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(646, 'Светлое нашествие саранчи', 5, '万蛊食天1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(648, 'Светлая стена шипов', 5, '荆棘术1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(650, 'Светлая жизненная сила', 5, '强体术1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(652, 'Светлая духовная сила', 5, '神辅术1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(654, 'Светлый перенос души', 5, '移元术1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(656, 'Светлое обращение в лисицу', 5, '灵狐变1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(658, 'Светлые когти лисицы', 5, '妖狐击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(660, 'Светлый огонь духов', 5, '妖雾击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(662, 'Светлый хвост лисицы', 5, '妖缠击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(664, 'Светлая тень лисицы', 5, '妖魂击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(666, 'Светлая хитрость лисицы', 5, '妖灵击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(668, 'Светлый дух лисицы', 5, '妖煞击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(670, 'Светлое изгнание', 5, '驱逐咒1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(672, 'Светлое проклятие уязвимости', 5, '残体咒1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(674, 'Светлое проклятие слабости', 5, '弱魂咒1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(676, 'Светлое проклятие истощения', 5, '碎灵咒1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(678, 'Светлая звериная ярость', 5, '拳术精通1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(680, 'Светлое знание стихии дерева', 5, '木系精通1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(763, 'Светлый наряд из цветов', 5, '妖狐附体1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1825, 'Истребление - Проклятая связь', 6, '万蛊洪流.dds', 3, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1826, 'Колдовство', 6, '妖气击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1827, 'Сокрушение духа', 6, '致残咒.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1828, 'Парный танец', 6, '火狐之术.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1829, 'Пламенная преграда', 6, '灵火.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1867, 'Проклятая связь', 6, '万蛊洪流.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1929, 'Колдовство', 6, '妖气击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1930, 'Колдовство', 6, '妖气击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2231, 'Демоническое каменное проклятье', 7, '荒·赤岩蛊.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2233, 'Демонический удар гнева', 7, '荒·妖怨击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2235, 'Демонический удар мрака', 7, '荒·妖冥击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2237, 'Демонический дух лисицы', 7, '妖煞击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2417, 'Демонический хвост лисицы', 7, '妖缠击2.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2230, 'Божественное каменное проклятье', 8, '玄·赤岩蛊.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2232, 'Божественный удар гнева', 8, '玄·妖怨击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2234, 'Божественный удар мрака', 8, '玄·妖冥击.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2236, 'Божественный дух лисицы', 8, '妖煞击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2416, 'Божественный хвост лисицы', 8, '妖缠击1.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 3, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(102, 'Звериный молот', 0, '兽王锤.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(103, 'Мастерство пловца', 0, '水性精通.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(104, 'Тысячетонный молот', 0, '千斤锤.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(105, 'Пылающий ветер', 0, '风火轮.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(106, 'Уничтожение', 0, '破甲一击.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(107, 'Раскалывающаяся земля', 0, '地裂.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(108, 'Вызов', 0, '兽王无敌.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(109, 'Сила зверя', 0, '野性回复.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(111, 'Кипящая кровь', 0, '化血成魔.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(112, 'Облик тигра', 0, '白虎变.dds', 4, 3, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(12, 'Похоронный колокол', 0, '巨浪.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(13, 'Армагеддон', 0, '毁天灭地.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(149, 'Ярость тигра', 0, '虎扑.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(150, 'Яростный укус', 0, '撕咬.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(151, 'Пожирание', 0, '吞噬.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(152, 'Сила волны', 0, '排山倒海.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(153, 'Разверзшиеся небеса', 0, '兽王之怒.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(154, 'Шкура зверя', 0, '变身强化.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(155, 'Ядовитые клыки', 0, '毒牙.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(156, 'Трепет', 0, '震慑.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(162, 'Техника боя с молотом', 0, '斧锤精通.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(185, 'Призывный рык', 0, '咆哮.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(186, 'Завеса тьмы', 0, '玄武附体.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(188, 'Неистовство зверя', 0, '兽王之怒新.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(195, 'Удавка', 0, '绞杀.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(230, 'Вспышка ци', 0, '爆气1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(231, 'Высшая вспышка ци', 0, '爆气2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(82, 'Рев главы стаи', 0, '兽王鼓舞.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(83, 'Невероятная сила', 0, '巨灵神力.dds', 4, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(906, 'Свирепый рев', 1, '野性咆哮.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(907, 'Ярость титана', 1, '巨灵狂暴.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1981, 'Темный облик тигра (усиленное)', 2, '白虎变2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1983, 'Темное обращение в солнечную панду', 2, '狂熊猫变.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(929, 'Вспышка гнева', 2, '狂怒.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(935, 'Ярость божества', 2, '兽神之怒.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1980, 'Светлый облик тигра (усиленное)', 3, '白虎变1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1982, 'Светлое обращение в солнечную панду', 3, '真熊猫变.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(908, 'Вспышка гнева', 3, '狂怒.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(909, 'Ярость божества', 3, '兽神之怒.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(367, 'Вспышка демона', 4, '魔元爆发.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(493, 'Темный звериный молот', 4, '兽王锤2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(495, 'Темная удавка', 4, '绞杀2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(497, 'Темный похоронный колокол', 4, '巨浪2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(499, 'Темный тысячетонный молот', 4, '千斤锤2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(501, 'Темное уничтожение', 4, '破甲一击2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(503, 'Темный пылающий ветер', 4, '风火轮2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(505, 'Темная раскалывающаяся земля', 4, '地裂2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(507, 'Темный вызов', 4, '兽王无敌2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(509, 'Темный Армагеддон', 4, '毁天灭地2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(511, 'Темная сила зверя', 4, '野性回复2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(513, 'Темный рев главы стаи', 4, '兽王鼓舞2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(515, 'Темная кипящая кровь', 4, '化血成魔2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(517, 'Темная невероятная сила', 4, '巨灵神力2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(519, 'Темный облик тигра', 4, '白虎变2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(521, 'Темный яростный укус', 4, '撕咬2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(523, 'Темная ярость тигра', 4, '怒扑2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(525, 'Темное пожирание', 4, '吞噬2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(527, 'Темная сила волны', 4, '排山倒海2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(529, 'Темные разверзшиеся небеса', 4, '兽王之怒2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(531, 'Темное неистовство зверя', 4, '天崩地裂2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(533, 'Темные ядовитые клыки', 4, '毒牙2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(535, 'Темный призывный рык', 4, '咆哮2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(537, 'Темный трепет', 4, '震慑2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(539, 'Темная шкура зверя', 4, '变身强化2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(541, 'Темная техника боя с молотом', 4, '斧锤精通2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(366, 'Вспышка бессмертного', 5, '仙元爆发.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(492, 'Светлый звериный молот', 5, '兽王锤1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(494, 'Светлая удавка', 5, '绞杀1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(496, 'Светлый похоронный колокол', 5, '巨浪1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(498, 'Светлый тысячетонный молот', 5, '千斤锤1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(500, 'Светлое уничтожение', 5, '破甲一击1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(502, 'Светлый пылающий ветер', 5, '风火轮1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(504, 'Светлая раскалывающаяся земля', 5, '地裂1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(506, 'Светлый вызов', 5, '兽王无敌1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(508, 'Светлый Армагеддон', 5, '毁天灭地1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(510, 'Светлая сила зверя', 5, '野性回复1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(512, 'Светлый рев главы стаи', 5, '兽王鼓舞1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(514, 'Светлая кипящая кровь', 5, '化血成魔1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(516, 'Светлая невероятная сила', 5, '巨灵神力1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(518, 'Светлый облик тигра', 5, '白虎变1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(520, 'Светлый яростный укус', 5, '撕咬1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(522, 'Светлая ярость тигра', 5, '怒扑1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(524, 'Светлое пожирание', 5, '吞噬1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(526, 'Светлая сила волны', 5, '排山倒海1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(528, 'Светлые разверзшиеся небеса', 5, '兽王之怒1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(530, 'Светлое неистовство зверя', 5, '天崩地裂1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(532, 'Светлые ядовитые клыки', 5, '毒牙1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(534, 'Светлый призывный рык', 5, '咆哮1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(536, 'Светлый трепет', 5, '震慑1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(538, 'Светлая шкура зверя', 5, '变身强化1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(540, 'Светлая техника боя с молотом', 5, '斧锤精通1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1830, 'Дразнящий шлепок', 6, '奋战扫击.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1831, 'Ярость героя', 6, '无冕之王.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1832, 'Адреналин', 6, '无畏.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1833, 'Истребление - Сбитый дракон', 6, '妖兽之力.dds', 4, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1834, 'Загнанный зверь', 6, '虎啸.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1877, 'Сбитый дракон', 6, '妖兽之力.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2245, 'Демонический тысячетонный молот', 7, '千斤锤2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2248, 'Демоническое разверзшееся небо', 7, '兽王之怒2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2419, 'Демонический звериный молот', 7, '兽王锤2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2421, 'Демонический вызов', 7, '兽王无敌2.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2244, 'Божественный тысячетонный молот', 8, '千斤锤1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2247, 'Божественное разверзшееся небо', 8, '兽王之怒1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2418, 'Божественный звериный молот', 8, '兽王锤1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2420, 'Божественный вызов', 8, '兽王无敌1.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 4, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1077, 'Разлом', 0, '爆弹.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1080, 'Мастер кинжала', 0, '匕首精通.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1081, 'Мягкая поступь', 0, '身形精通.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1082, 'Орлиное зрение', 0, '眼力精通.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1083, 'Проникающий удар', 0, '保命.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1086, 'Побег в тень', 0, '高级隐身.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1093, 'Растворение', 0, '隐身.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1094, 'Метка крови', 0, '吸血光环.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1095, 'Танец тени', 0, '瞬移.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1096, 'Обман смерти', 0, '回光返照.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1097, 'Печать бешеного волка', 0, '暴伤.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1098, 'Алмазная печать', 0, '伤害闪避.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1099, 'Проклятие трех поколений', 0, '状态闪避.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1111, 'Двойной удар', 0, '连击.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1112, 'Обезглавливание', 0, '十字斩.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1113, 'Хладнокровие', 0, '冰剑护体.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1114, 'Кровопускание', 0, '速斩.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1115, 'Удар в горло', 0, '旋风斩.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1118, 'Казнь', 0, '断筋.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1119, 'Бросок', 0, '丢飞刀.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1120, 'Равновесие', 0, '定身.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1121, 'Неистовый удар', 0, '断筋.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1122, 'Удар под ребра', 0, '刺腹.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1123, 'Глубокий укол', 0, '深刺.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1124, 'Быстрый ветер', 0, '刺客加速.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1138, 'Превращение в русалку', 0, '人鱼变.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1145, 'Прыжок сквозь тень', 0, '高级瞬移.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1148, 'Расправа', 0, '致盲.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1178, 'Вспышка ци', 0, '爆气1.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1179, 'Высшая вспышка ци', 0, '爆气2.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1180, 'Аркан убийцы', 0, '绊腿.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1181, 'Укус дракона', 0, '先发制人.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1189, 'Кошачий шаг', 0, '凌波微步.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1201, 'Ледяной шип', 0, '凝霜刺.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1200, 'Поток жизни', 1, '龟息咒.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1324, 'Подлый удар', 2, '断法击.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1325, 'Кровопийца', 2, '嗜血狂乱.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1202, 'Подлый удар', 3, '断法击.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1203, 'Кровопийца', 3, '嗜血狂乱.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1196, 'Вспышка демона', 4, '魔元爆发.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1261, 'Темный разлом', 4, '爆弹魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1263, 'Темный мастер кинжала', 4, '匕首精通魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1269, 'Темный проникающий  удар', 4, '保命魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1273, 'Темный побег в тень', 4, '高级隐身魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1275, 'Темное растворение', 4, '隐身魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1277, 'Темная метка крови', 4, '吸血光环魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1279, 'Темный танец тени', 4, '瞬移魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1281, 'Темный обман смерти', 4, '回光返照魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1283, 'Темная печать бешеного волка', 4, '暴伤魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1285, 'Темная алмазная печать', 4, '伤害闪避魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1287, 'Темное проклятие трех поколений', 4, '状态闪避魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1289, 'Темный двойной удар', 4, '连击魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1291, 'Темное обезглавливание', 4, '十字斩魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1293, 'Темное хладнокровие', 4, '冰剑护体魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1295, 'Темное кровопукание', 4, '撕裂伤口魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1297, 'Темный удар в горло', 4, '旋风斩魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1299, 'Темная казнь', 4, '速斩魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1301, 'Темный бросок', 4, '丢飞刀魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1303, 'Темное равновесие', 4, '定身魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1305, 'Темный неистовый удар', 4, '断筋魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1307, 'Темный удар под ребра', 4, '刺腹魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1309, 'Темный глубокий укол', 4, '深刺魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1311, 'Темный быстрый ветер', 4, '刺客加速魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1315, 'Темный прыжок сквозь тень', 4, '高级瞬移魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1317, 'Темная расправа', 4, '致盲魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1319, 'Темный аркан убийцы', 4, '绊腿魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1321, 'Темный укус дракона', 4, '先发制人魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1323, 'Темный кошачий шаг', 4, '凌波微步魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1197, 'Вспышка бессмертного', 5, '仙元爆发.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1260, 'Светлый разлом', 5, '爆弹仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1262, 'Светлый мастер кинжала', 5, '匕首精通仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1268, 'Светлый проникающий  удар', 5, '保命仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1272, 'Светлый побег в тень', 5, '高级隐身仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1274, 'Светлое растворение', 5, '隐身仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1276, 'Светлая метка крови', 5, '吸血光环仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1278, 'Светлый танец тени', 5, '瞬移仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1280, 'Светлый обман смерти', 5, '回光返照仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1282, 'Светлая печать бешеного волка', 5, '暴伤仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1284, 'Светлая алмазная печать', 5, '伤害闪避仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1286, 'Светлое проклятие трех поколений', 5, '状态闪避仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1288, 'Светлый двойной удар', 5, '连击仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1290, 'Светлое обезглавливание', 5, '十字斩仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1292, 'Светлое хладнокровие', 5, '冰剑护体仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1294, 'Светлое кровопускание', 5, '撕裂伤口仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1296, 'Светлый удар в горло', 5, '旋风斩仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1298, 'Светлая казнь', 5, '速斩仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1300, 'Светлый бросок', 5, '丢飞刀仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1302, 'Светлое равновесие', 5, '定身仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1304, 'Светлый неистовый удар', 5, '断筋仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1306, 'Светлый удар под ребра', 5, '刺腹仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1308, 'Светлый глубокий укол', 5, '深刺仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1310, 'Светлый быстрый ветер', 5, '刺客加速仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1314, 'Светлый прыжок сквозь тень', 5, '高级瞬移仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1316, 'Светлая расправа', 5, '致盲仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1318, 'Светлый аркан убийцы', 5, '绊腿仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1320, 'Светлый укус дракона', 5, '先发制人仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1322, 'Светлый кошачий шаг', 5, '凌波微步仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1835, 'Затмение', 6, '日冕.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1836, 'Отнять и поделить', 6, '飘零.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1837, 'Отравленное лезвие', 6, '毒仞.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1838, 'Досмотр', 6, '影嗜.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1839, 'Яньфу - Смертельная связь', 6, '葬魂印记.dds', 5, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1876, 'Смертельная связь', 6, '葬魂印记.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1949, 'Защита богатств', 6, '飘零.dds', 5, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2213, 'Демоническая кража жизни', 7, '荒·追命.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2215, 'Семь демонических убийств', 7, '荒·七杀.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2439, 'Демоническое хладнокровие', 7, '冰剑护体魔技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2451, 'Демоническая великая тюрьма', 7, '荒·杀戮盛宴.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2212, 'Божественная кража жизни', 8, '玄·追命.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2214, 'Семь божественных убийств', 8, '玄·七杀.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2366, 'Божественная великая тюрьма', 8, '玄·杀戮盛宴.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2438, 'Божественное хладнокровие', 8, '冰剑护体仙技能.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 5, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(234, 'Прицел', 0, '引而不发.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(235, 'Беглый огонь', 0, '连射.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(236, 'Отбрасывающая стрела', 0, '击退矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(237, 'Связывающая стрела', 0, '混乱矢(虚弱矢).dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(238, 'Взрывающаяся стрела', 0, '击晕矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(239, 'Смертоносная стрела', 0, '致命矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(240, 'Буря стрел', 0, '箭阵.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(241, 'Удар молнии', 0, '落雷.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(242, 'Грозовое небо', 0, '惊雷.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(243, 'Гром и молния', 0, '炸雷.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(244, 'Огненные стрелы', 0, '烈焰之矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(245, 'Ледяная стрела', 0, '寒冰之矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(246, 'Змеиная стрела', 0, '蛇蝎之矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(247, 'Зазубренная стрела', 0, '尖牙之矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(248, 'Разрывная стрела', 0, '利齿之矢.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(249, 'Перистый барьер', 0, '翼盾.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(250, 'Удар крыльями', 0, '翼击.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(251, 'Взмах крыльев', 0, '翼展.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(252, 'Парящий орел', 0, '神鹰翼扬.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(253, 'Когти небес', 0, '狂雷天鹰.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(254, 'Ножны из перьев', 0, '羽之守护(神鹰祝福).dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(255, 'Сто шагов', 0, '百步穿杨.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(256, 'Мастерство стрельбы', 0, '弓弩精通.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(257, 'Вспышка ци', 0, '爆气1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(258, 'Высшая вспышка ци', 0, '爆气2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(274, 'Мастерство полета', 0, '飞行精通.dds', 6, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(915, 'Скорость эльфа', 1, '翼风.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(916, 'Защита божественного ястреба', 1, '神鹰庇佑.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(931, 'Пробуждение души', 2, '元魂迸发.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(932, 'Кровавая стрела', 2, '血矢.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(917, 'Пробуждение души', 3, '元魂迸发.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(918, 'Кровавая стрела', 3, '血矢.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(371, 'Вспышка демона', 4, '魔元爆发.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(591, 'Темный прицел', 4, '引而不发2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(593, 'Темный беглый огонь', 4, '连射2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(595, 'Темная отбрасывающая стрела', 4, '击退矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(597, 'Темная связывающая стрела', 4, '困缚矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(599, 'Темная взрывающаяся стрела', 4, '击晕矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(601, 'Темная смертоносная стрела', 4, '致命矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(603, 'Темная буря стрел', 4, '箭阵2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(605, 'Темный удар молнии', 4, '落雷2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(607, 'Темное грозовое небо', 4, '惊雷2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(609, 'Темные гром и молния', 4, '炸雷2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(611, 'Темные когти небес', 4, '狂雷天鹰2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(613, 'Темные огненные стрелы', 4, '烈焰之矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(615, 'Темная ледяная стрела', 4, '寒冰之矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(617, 'Темная змеиная стрела', 4, '蛇蝎之矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(619, 'Темная зазубренная стрела', 4, '尖牙之矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(621, 'Темная разрывная стрела', 4, '利齿之矢2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(623, 'Темный перистый барьер', 4, '翼盾2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(625, 'Темный удар крыльями', 4, '翼击2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(627, 'Темный взмах крыльев', 4, '翼展2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(629, 'Темные ножны из перьев', 4, '羽之守护2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(631, 'Темные сто шагов', 4, '百步穿杨2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(633, 'Темное мастерство стрельбы', 4, '弓弩精通2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(370, 'Вспышка бессмертного', 5, '仙元爆发.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(590, 'Светлый прицел', 5, '引而不发1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(592, 'Светлый беглый огонь', 5, '连射1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(594, 'Светлая отбрасывающая стрела', 5, '击退矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(596, 'Светлая связывающая стрела', 5, '困缚矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(598, 'Светлая взрывающаяся стрела', 5, '击晕矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(600, 'Светлая смертоносная стрела', 5, '致命矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(602, 'Светлая буря стрел', 5, '箭阵1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(604, 'Светлый удар молнии', 5, '落雷1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(606, 'Светлое грозовое небо', 5, '惊雷1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(608, 'Светлые гром и молния', 5, '炸雷1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(610, 'Светлые когти небес', 5, '狂雷天鹰1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(612, 'Светлые огненные стрелы', 5, '烈焰之矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(614, 'Светлая ледяная стрела', 5, '寒冰之矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(616, 'Светлая змеиная стрела', 5, '蛇蝎之矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(618, 'Светлая зазубренная стрела', 5, '尖牙之矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(620, 'Светлая разрывная стрела', 5, '利齿之矢1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(622, 'Светлый перистый барьер', 5, '翼盾1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(624, 'Светлый удар крыльями', 5, '翼击1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(626, 'Светлый взмах крыльев', 5, '翼展1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(628, 'Светлые ножны из перьев', 5, '羽之守护1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(630, 'Светлые сто шагов', 5, '百步穿杨1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(632, 'Светлое мастерство стрельбы', 5, '弓弩精通1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1840, 'Пронзающая стрела', 6, '软骨之矢.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1841, 'Крылья - Сила грозы', 6, '擎天雷鸣.dds', 6, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1842, 'Солнечная стрела', 6, '落日矢.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1843, 'Спокойствие', 6, '回旋之翼.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1844, 'Прыжок влево', 6, '无上之翼左 .dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1845, 'Прыжок вправо', 6, '无上之翼右.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1866, 'Сила грозы', 6, '擎天雷鸣.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2217, 'Демонические стрелы мороза', 7, '荒·冰霜散射.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2219, 'Демонический поцелуй змеи', 7, '荒·蛇蝎之吻.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2221, 'Демоническое изничтожение', 7, '荒·三千羽杀尽.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2433, 'Демонический перистый барьер', 7, '翼盾2.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2216, 'Божественные стрелы мороза', 8, '玄·冰霜散射.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2218, 'Божественный поцелуй змеи', 8, '玄·蛇蝎之吻.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2220, 'Божественное изничтожение', 8, '玄·三千羽杀尽.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2432, 'Божественный перистый барьер', 8, '翼盾1.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 6, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(11, 'Знание стихии металла', 0, '金精通.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(113, 'Молитва о ясности', 0, '清心咒.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(114, 'Молитва о спокойствии', 0, '静心符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(115, 'Воодушевление', 0, '醍醐灌顶.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(116, 'Бескрайнее море', 0, '海纳百川.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(117, 'Печать пяти измерений', 0, '五体符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(118, 'Печать пяти звуков', 0, '五音符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(119, 'Печать пяти цветов', 0, '五色符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(120, 'Железный покров', 0, '坚甲符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(121, 'Оплот духа', 0, '真灵护体.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(122, 'Мудрость небес', 0, '乾坤借法.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(123, 'Прикосновение пустоты', 0, '天地无极.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(124, 'Благословенный символ', 0, '神兵利器.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(125, 'Оперенная стрела', 0, '羽箭.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(126, 'Рассекающие перья', 0, '羽刃.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(127, 'Смерч', 0, '龙卷风.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(128, 'Священная молния', 0, '神雷.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(129, 'Пронизывающий ветер', 0, '和风拂面.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(130, 'Ярость небес', 0, '狂雷天威.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(15, 'Утренняя заря', 0, '五气朝元.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(16, 'Аура восстановления', 0, '极度乾坤.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(163, 'Каскад молний', 0, '雷链.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(17, 'Печать пяти стихий', 0, '五行符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(18, 'Молитва о жизни', 0, '还魂咒.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(189, 'Рассеивание', 0, '玄净咒.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(19, 'Преграда из перьев', 0, '羽盾.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(190, 'Мастерство полета', 0, '飞行精通.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(191, 'Опека духов', 0, '聚神符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(192, 'Эгида бессмертных', 0, '仙守符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(193, 'Сила мысли', 0, '灵助符.dds', 7, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(194, 'Оплот тела', 0, '天师护体.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(232, 'Вспышка ци', 0, '爆气1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(233, 'Высшая вспышка ци', 0, '爆气2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(919, 'Заступничество света', 1, '护体神光.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(920, 'Защита крыльев', 1, '羽之守护.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(933, 'Ярость ветра', 2, '镇魂五音.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(934, 'Печать бога', 2, '神之封印.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(921, 'Ярость ветра', 3, '镇魂五音.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(922, 'Печать бога', 3, '神之封印.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(373, 'Вспышка демона', 4, '魔元爆发.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(543, 'Темная молитва о ясности', 4, '清心咒2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(545, 'Темная молитва о спокойствии', 4, '静心符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(547, 'Темное воодушевление', 4, '醍醐灌顶2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(549, 'Темная молитва о жизни', 4, '还魂咒2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(551, 'Темное рассеивание', 4, '玄净咒2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(553, 'Темная утренняя заря', 4, '五气朝元2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(555, 'Темное бескрайнее море', 4, '海纳百川2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(557, 'Темная печать пяти стихий', 4, '五行符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(559, 'Темная печать пяти измерений', 4, '五体符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(561, 'Темная печать пяти звуков', 4, '五音符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(563, 'Темная печать пяти цветов', 4, '五色符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(565, 'Темный железный покров', 4, '坚甲符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(567, 'Темная опека духов', 4, '聚神符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(569, 'Темная эгида бессмертных', 4, '仙守符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(571, 'Темная сила мысли', 4, '灵助符2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(573, 'Темная оперенная стрела', 4, '羽箭2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(575, 'Темная преграда из перьев', 4, '羽盾2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(577, 'Темные рассекающие перья', 4, '羽刃2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(579, 'Темный смерч', 4, '龙卷风2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(581, 'Темная священная молния', 4, '神雷2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(583, 'Темный пронизывающий ветер', 4, '和风拂面2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(586, 'Темный каскад молний', 4, '雷链2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(587, 'Темная ярость небес', 4, '狂雷天威2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(589, 'Темное знание стихии металла', 4, '金精通2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(372, 'Вспышка бессмертного', 5, '仙元爆发.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(542, 'Светлая молитва о ясности', 5, '清心咒1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(544, 'Светлая молитва о спокойствии', 5, '静心符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(546, 'Светлое воодушевление', 5, '醍醐灌顶1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(548, 'Светлая молитва о жизни', 5, '还魂咒1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(550, 'Светлое рассеивание', 5, '玄净咒1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(552, 'Светлая утренняя заря', 5, '五气朝元1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(554, 'Светлое бескрайнее море', 5, '海纳百川1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(556, 'Светлая печать пяти стихий', 5, '五行符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(558, 'Светлая печать пяти измерений', 5, '五体符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(560, 'Светлая печать пяти звуков', 5, '五音符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(562, 'Светлая печать пяти цветов', 5, '五色符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(564, 'Светлый железный покров', 5, '坚甲符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(566, 'Светлая опека духов', 5, '聚神符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(568, 'Светлая эгида бессмертных', 5, '仙守符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(570, 'Светлая сила мысли', 5, '灵助符1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(572, 'Светлая оперенная стрела', 5, '羽箭1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(574, 'Светлая преграда из перьев', 5, '羽盾1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(576, 'Светлые рассекающие перья', 5, '羽刃1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(578, 'Светлый смерч', 5, '龙卷风1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(580, 'Светлая священная молния', 5, '神雷1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(582, 'Светлый пронизывающий ветер', 5, '和风拂面1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(584, 'Светлый каскад молний', 5, '雷链1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(585, 'Светлая ярость небес', 5, '狂雷天威1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(588, 'Светлое знание стихии металла', 5, '金精通1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1804, 'Забота богов', 6, '众神的眷顾.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1810, 'Луч боли', 6, '羽斩.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1811, 'Крылья - Ночной танец', 6, '雷火坠.dds', 7, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1812, 'Северное сияние', 6, '流光溢彩.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1813, 'Набожность', 6, '天瀑符.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1814, 'Печать грома', 6, '五感符.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1857, 'Поглощающее сияние', 6, '雷鸣静心符.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1869, 'Ночной танец', 6, '雷火坠.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2413, 'Демоническое чистое сердце', 7, '醍醐灌顶2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2415, 'Демонический смерч', 7, '龙卷风2.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2412, 'Божественное чистое сердце', 8, '醍醐灌顶1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2414, 'Божественный смерч', 8, '龙卷风1.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2222, 'Милость богов', 9, '至·诸神之佑.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2223, 'Исцеляющая аура', 9, '极度乾坤.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2224, 'Дыхание пустоты', 9, '天地无极.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 7, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1340, 'Магия клинка единства', 0, '三才剑咒.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1341, 'Сияние меча', 0, '剑心通明.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1342, 'Магия клинка вселенной', 0, '六合剑咒.dds', 8, 3, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1343, 'Магия клинка империи', 0, '九宫剑咒.dds', 8, 3, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1344, 'Техника черного воина', 0, '玄武剑诀.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1345, 'Техника кровавого меча', 0, '饮血剑诀.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1346, 'Техника каменного змея', 0, '磐龙剑诀.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1347, 'Алмазное клеймо', 0, '金刚剑印.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1348, 'Морозное клеймо', 0, '寒潮剑印.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1349, 'Обжигающее клеймо', 0, '焚心剑印.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1350, 'Сила камня', 0, '碎石剑气.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1351, 'Сила ветра', 0, '刺客加速.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1352, 'Сила луны', 0, '流光剑劲.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1353, 'Закаленный меч', 0, '玄铁剑意.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1354, 'Удар пустоты', 0, '虚空剑劲.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1355, 'Меч огненного духа', 0, '熔心剑意.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1356, 'Мощь яростного медведя', 0, '天罡剑气.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1357, 'Сила тысячи зверей', 0, '万象剑劲.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1358, 'Меч сотни теней', 0, '八方剑影.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1359, 'Воронка лезвий', 0, '剑神无敌.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1360, 'Избавление', 0, '逍遥诀.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1361, 'Железная плоть', 0, '琉璃金身.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1362, 'Меч императора', 0, '御心剑.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1363, 'Блуждающий призрак', 0, '身外化身.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1371, 'Техника боя с мечом', 0, '刀剑精通.dds', 8, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1372, 'Вспышка ци', 0, '爆气1.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1373, 'Высшая вспышка ци', 0, '爆气2.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1731, 'Исцеляющий свет', 1, '回光诀.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1732, 'Мощь летящего дракона', 1, '翔龙剑劲.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1734, 'Невидимое лезвие', 2, '归刃诀.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1738, 'Техника девяти мечей', 2, '九尊剑诀.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1733, 'Невидимое лезвие', 3, '归刃诀.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1735, 'Техника девяти мечей', 3, '九尊剑诀.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1667, 'Темная техника черного воина', 4, '玄武剑诀魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1673, 'Темная техника кровавого меча', 4, '饮血剑诀魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1679, 'Темная техника каменного змея', 4, '磐龙剑诀魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1683, 'Темное алмазное клеймо', 4, '金刚剑印魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1685, 'Темное морозное клеймо', 4, '寒潮剑印魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1687, 'Темное обжигающее клеймо', 4, '焚心剑印魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1689, 'Темное избавление', 4, '逍遥诀魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1691, 'Темный меч императора', 4, '御心剑魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1693, 'Темное сияние меча', 4, '剑心通明魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1695, 'Темный блуждающий призрак', 4, '御心剑魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1697, 'Темная железная плоть', 4, '琉璃剑阵魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1699, 'Темная сила камня', 4, '碎石剑气魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1701, 'Темная сила ветра', 4, '破风剑气魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1703, 'Темный закаленный меч', 4, '玄铁剑意魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1705, 'Темный удар пустоты', 4, '虚空剑劲魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1707, 'Темная мощь яростного медведя', 4, '天罡剑气魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1709, 'Темный меч огненного духа', 4, '熔心剑意魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1711, 'Темная сила тысячи зверей', 4, '万象剑劲魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1713, 'Темная воронка лезвий', 4, '剑神无敌魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1715, 'Вспышка демона', 4, '魔元爆发.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1717, 'Темная техника боя с мечом', 4, '刀剑精通2.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1720, 'Темный меч сотни теней', 4, '八方剑影魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1740, 'Темная сила луны', 4, '流光剑劲魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1664, 'Светлая техника черного воина', 5, '玄武剑诀仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1670, 'Светлая техника кровавого меча', 5, '饮血剑诀仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1676, 'Светлая техника каменного змея', 5, '磐龙剑诀仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1682, 'Светлое алмазное клеймо', 5, '金刚剑印仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1684, 'Светлое морозное клеймо', 5, '寒潮剑印仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1686, 'Светлое обжигающее клеймо', 5, '焚心剑印仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1688, 'Светлое избавление', 5, '逍遥诀仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1690, 'Светлый меч императора', 5, '御心剑仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1692, 'Светлое сияние меча', 5, '剑心通明仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1694, 'Светлый блуждающий призрак', 5, '身外化身仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1696, 'Светлая железная плоть', 5, '琉璃剑阵仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1698, 'Светлая сила камня', 5, '碎石剑气仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1700, 'Светлая сила ветра', 5, '破风剑气仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1702, 'Светлый закаленный меч', 5, '玄铁剑意仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1704, 'Светлый удар пустоты', 5, '虚空剑劲仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1706, 'Светлая мощь яростного медведя', 5, '天罡剑气仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1708, 'Светлый меч огненного духа', 5, '熔心剑意仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1710, 'Светлая сила тысячи зверей', 5, '万象剑劲仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1712, 'Светлая воронка лезвий', 5, '剑神无敌仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1714, 'Вспышка бессмертного', 5, '仙元爆发.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1716, 'Светлая техника боя с мечом', 5, '刀剑精通1.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1718, 'Светлый меч сотни теней', 5, '八方剑影仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1739, 'Светлая сила луны', 5, '流光剑劲仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1846, 'Кровавый меч', 6, '剑景.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1847, 'Жертвенный запал', 6, '血牙剑气.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1850, 'Чистота - Зов меча', 6, '乱舞剑咒.dds', 8, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1856, 'Транспозиция', 6, '桎梏诀2.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1863, 'Проницательный взгляд', 6, '灵眸.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1870, 'Зов меча', 6, '乱舞剑咒.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2250, 'Демоническое клеймо хаоса', 7, '荒·混沌剑印.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2253, 'Демонический блуждающий призрак', 7, '御心剑魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2445, 'Демонический меч-костолом', 7, '碎石剑气魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2448, 'Демонический меч-ветрогон', 7, '破风剑气魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2450, 'Демонический сияющий меч', 7, '流光剑劲魔技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2249, 'Божественное клеймо хаоса', 8, '玄·混沌剑印.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2252, 'Божественный блуждающий призрак', 8, '身外化身仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2442, 'Божественный меч-костолом', 8, '碎石剑气仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2447, 'Божественный меч-ветрогон', 8, '破风剑气仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2449, 'Божественный сияющий меч', 8, '流光剑劲仙技能.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2251, 'Жертвенный огонь', 9, '血牙剑气.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 8, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1374, 'Путы плюща', 0, '腐蔓咒.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1375, 'Зеленый туман', 0, '碧云术.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1376, 'Дьявольское проклятие', 0, '勾魂摄魄.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1377, 'Шквал', 0, '长风破.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1378, 'Цветочная буря', 0, '东风咒.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1379, 'Листва', 0, '铁木衫.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1380, 'Ускорение магии', 0, '风竹秋韵.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1381, 'Целительный свет', 0, '岐黄妙手.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1382, 'Заживляющий туман', 0, '萦风抱雾.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1383, 'Облако лепестков', 0, '回风回柳.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1384, 'Заросли', 0, '满地枝.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1385, 'Помощь воина', 0, '魔神蚩尤.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1386, 'Помощь демона', 0, '金光电母.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1387, 'Небесная заступница', 0, '清净琉璃.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1388, 'Вестник рока', 0, '火神下界.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1389, 'Проклятый шип', 0, '莲子止魂.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1390, 'Зачарованная лоза', 0, '绛珠之咒.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1391, 'Волшебный вьюнок', 0, '百裂缠丝.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1392, 'Колдовской анемон', 0, '情意眠眠.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1393, 'Целебная трава', 0, '玉暖蓝田.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1394, 'Трава жизни', 0, '残阳如血.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1395, 'Знание стихии дерева', 0, '木系精通.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1396, 'Вспышка ци', 0, '爆气1.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1397, 'Высшая вспышка ци', 0, '爆气2.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1398, 'Ярость флоры', 0, '枯荣法.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1399, 'Перенос силы', 0, '同气连枝.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1400, 'Свет звезд', 0, '移神术.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1401, 'Возрождение', 0, '枯木逢春.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1498, 'Лечение помощника', 0, '治疗宠物.dds', 9, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1723, 'Созерцание', 1, '灵犀.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1724, 'Щит природы', 1, '自然障壁.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1726, 'Чутье', 2, '灵机.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1728, 'Танец дрожащего облака', 2, '云摇.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1730, 'Танец слез ветра', 2, '风泣.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1725, 'Чутье', 3, '灵机.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1727, 'Танец дрожащего облака', 3, '云摇.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1729, 'Танец слез ветра', 3, '风泣.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1619, 'Темные путы плюща', 4, '腐蔓咒魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1621, 'Темный зеленый туман', 4, '碧云术魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1623, 'Темное дьявольское проклятие', 4, '勾魂摄魄魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1625, 'Темный шквал', 4, '长风破魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1627, 'Темная цветочная буря', 4, '东风咒魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1629, 'Темная листва', 4, '铁木衫魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1631, 'Темное ускорение магии', 4, '风竹秋韵魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1633, 'Темный целительный свет', 4, '岐黄妙手魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1635, 'Темный заживляющий туман', 4, '萦风抱雾魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1637, 'Темное облако лепестков', 4, '回风拂柳魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1639, 'Темное возрождение', 4, '枯木逢春魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1641, 'Темное знание стихии дерева', 4, '木系精通2.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1643, 'Темный перенос силы', 4, '同气连枝魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1645, 'Вспышка демона', 4, '魔元爆发.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1652, 'Темные заросли', 4, '满地枝魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1657, 'Темная помощь воина', 4, '魔神蚩尤魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1659, 'Темная помощь демона', 4, '金光电母魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1661, 'Темная небесная заступница', 4, '清净琉璃魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1663, 'Темный вестник рока', 4, '火神下界魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(361, 'Раздор', 4, '挑衅.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1618, 'Светлые путы плюща', 5, '腐蔓咒仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1620, 'Светлый зеленый туман', 5, '碧云术仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1622, 'Светлое дьявольское проклятие', 5, '勾魂摄魄仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1624, 'Светлый шквал', 5, '长风破仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1626, 'Светлая цветочная буря', 5, '东风咒仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1628, 'Светлая листва', 5, '铁木衫仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1630, 'Светлое ускорение магии', 5, '风竹秋韵仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1632, 'Светлый целительный свет', 5, '岐黄妙手仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1634, 'Светлый заживляющий туман', 5, '萦风抱雾仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1636, 'Светлое облако лепестков', 5, '回风拂柳仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1638, 'Светлое возрождение', 5, '枯木逢春仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1640, 'Светлое знание стихии дерева', 5, '木系精通1.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1642, 'Светлый перенос силы', 5, '同气连枝仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1644, 'Вспышка бессмертного', 5, '仙元爆发.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1651, 'Светлые заросли', 5, '暴雨梨花诀仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1653, 'Светлая помощь воина', 5, '魔神蚩尤仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1658, 'Светлая помощь демона', 5, '金光电母仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1660, 'Светлая небесная заступница', 5, '清净琉璃仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1662, 'Светлый вестник рока', 5, '火神下界仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(360, 'Сила бессмертия', 5, '蓄气.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1852, 'Звездное пламя', 6, '流星.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1853, 'Цветочный вихрь', 6, '迷色万花.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1854, 'Пестрый фейерверк', 6, '繁星.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1855, 'Чистота - Звездное пламя', 6, '流星.dds', 9, 2, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1859, 'Благодеяние', 6, '百花缭乱.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1860, 'Всеобщее омоложение', 6, '万物回春.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1862, 'Следящее око', 6, '灵瞳.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2227, 'Танцующие облака', 7, '至·再舞风云.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2229, 'Демонический зеленый туман', 7, '碧云术魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2441, 'Демоническая помощь воина', 7, '魔神蚩尤魔技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2226, 'Танцующие облака', 8, '至·再舞风云.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2228, 'Божественный зеленый туман', 8, '碧云术仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2440, 'Божественная помощь воина', 8, '魔神蚩尤仙技能.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2225, 'Взрыв флоры', 9, '枯荣法.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2443, 'Тысяча ветров', 9, '技能伤害提高.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2444, 'Заоблачный гром', 9, '暴击率提高.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(2446, 'Начало добродетелей', 9, '全系防御提高.dds', 9, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1402, 'Шлифовка', 0, '打磨精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(158, 'Кузнец', 0, '铁匠精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(159, 'Портной', 0, '裁缝精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(160, 'Ремесленник', 0, '巧匠精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(161, 'Аптекарь', 0, '药师精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(164, 'Полет', 0, '飞剑精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(165, 'Кутюрье модной одежды', 0, '时装精通.dds', 10, 10, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(167, 'Городской портал', 0, '水煞.dds', 10, 1, 1023, '10', 0, 0);
INSERT INTO `shop_skills` (`skillid`, `name`, `kind`, `icon`, `cls`, `max_lvl`, `class_mask`, `cost`, `enabled`, `buy_count`) VALUES(1722, 'Душевная теплота', 0, '夫妻传送.dds', 10, 1, 1023, '10', 0, 0);
ALTER TABLE `users` ADD `session_data` VARCHAR( 50 ) NOT NULL ;
ALTER TABLE `users` ADD `vkid` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `passwd`, ADD `vkname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `vkid`, ADD `steamid` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `vkname`, ADD `steamname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `steamid`;
ALTER TABLE `users` ADD `vkphoto` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `vkname`;
ALTER TABLE `users` ADD `steamphoto` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `steamname`;
ALTER TABLE `donate` ADD `p_sys_id` VARCHAR(20) NOT NULL DEFAULT '' AFTER `inv_id`;
ALTER TABLE  `lklogs` CHANGE  `desc`  `desc` VARCHAR( 1024 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `users` CHANGE `Prompt` `Prompt` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `users` CHANGE `vkid` `vkid` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `vkname` `vkname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `vkphoto` `vkphoto` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `steamid` `steamid` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `steamname` `steamname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `steamphoto` `steamphoto` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `referal` `referal` INT(11) NOT NULL DEFAULT '0', CHANGE `ipdata` `ipdata` VARCHAR(10000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `session_data` `session_data` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `users` CHANGE `bonus_data` `bonus_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `passwd` `passwd` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `shop_items` CHANGE `data` `data` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `discount_data` `discount_data` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `desc` `desc` VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `shop_items` CHANGE `data` `data` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `shop_items` CHANGE `discount_data` `discount_data` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `shop_items` CHANGE `desc` `desc` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
