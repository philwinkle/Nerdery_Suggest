<?php
/* @var $installer Nerdery_Suggest_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();
$nerdery_suggest_product = <<<SQL
DROP TABLE IF EXISTS `nerdery_suggest_product`;
CREATE TABLE IF NOT EXISTS `nerdery_suggest_product` (
  `entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(1024) NOT NULL,
  `votes` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `converted_at` timestamp NULL DEFAULT NULL,
  `is_converted` tinyint(1) NOT NULL,
  PRIMARY KEY (`entity_id`),
  UNIQUE KEY `product_name` (`product_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;
SQL;

$nerdery_suggest_log = <<<SQL
DROP TABLE IF EXISTS `nerdery_suggest_log`;
CREATE TABLE IF NOT EXISTS `nerdery_suggest_log` (
  `entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
SQL;

$installer->run($nerdery_suggest_product);
$installer->run($nerdery_suggest_log);
$installer->endSetup();
