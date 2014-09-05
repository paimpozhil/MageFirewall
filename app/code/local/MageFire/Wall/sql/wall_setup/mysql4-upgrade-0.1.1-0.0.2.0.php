<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('firewall_options')};
CREATE TABLE {$this->getTable('firewall_options')} (
  `option_id` int(11) unsigned NOT NULL auto_increment,
  `path` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
    ");  
$installer->endSetup(); 
