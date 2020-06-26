<?php

// Language files management
$path = OW::getPluginManager()->getPlugin('modnotes')->getRootDir() . 'langs.zip';
BOL_LanguageService::getInstance()->importPrefixFromZip($path, 'modnotes');

// Create new table in database
$query = "CREATE TABLE IF NOT EXISTS `" . OW_DB_PREFIX . "modnotes_notes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `memberid` VARCHAR(200) NOT NULL,
  `moderatorid` VARCHAR(200) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `content` TEXT NOT NULL,
  `timestamp` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

OW::getDbo()->query($query);



