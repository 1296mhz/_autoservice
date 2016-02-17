<?php

/**
-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `grease_rat_work`;
CREATE TABLE `grease_rat_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repairPost` int(11) NOT NULL,
  `customer` text COLLATE utf8_unicode_ci NOT NULL,
  `typeOfRepair` int(11) NOT NULL,
  `avtoModel` tinyint(4) NOT NULL,
  `mileage` int(11) NOT NULL,
  `gosNumber` text COLLATE utf8_unicode_ci NOT NULL,
  `vin` text COLLATE utf8_unicode_ci NOT NULL,
  `startdatetime` datetime NOT NULL,
  `enddatetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2016-02-15 17:06:28
*/
class GreaseRatEvent extends SimpleOrm
{
    protected static
      $table = 'grease_rat_work';
}
