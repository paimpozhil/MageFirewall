<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('firewall_rules')};
CREATE TABLE {$this->getTable('firewall_rules')} (
  `rules_id` int(11) unsigned NOT NULL auto_increment,
  `who` varchar(255) NOT NULL default '',
  `request` text NOT NULL default '',
  `what` text NOT NULL default '',
  `why` text NOT NULL default '',
  `level` text NOT NULL default '',
  `enabled` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`rules_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('firewall_version')};
CREATE TABLE {$this->getTable('firewall_version')} (
  `version_id` int(11) unsigned NOT NULL auto_increment,
  `version` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('firewall_logs')};
CREATE TABLE {$this->getTable('firewall_logs')} (
  `log_id` int(11) unsigned NOT NULL auto_increment,
  `ruleid` varchar(255) NULL default '',
  `summary` text NULL default '',
  `ip` varchar(255) NULL,
  `level` smallint(6) NULL,
  `created_time` datetime NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('firewall_whitelist')};
CREATE TABLE {$this->getTable('firewall_whitelist')} (
  `whitelist_id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(255) NOT NULL default '',
  `text` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `is_delete` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`whitelist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('firewall_blacklist')};
CREATE TABLE {$this->getTable('firewall_blacklist')} (
  `blacklist_id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(255) NOT NULL default '',
  `priority` varchar(255) NOT NULL default '',
  `text` text NOT NULL default '',
  `count` varchar(255) NOT NULL default '',
  `is_delete` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`blacklist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('firewall_options')};
CREATE TABLE {$this->getTable('firewall_options')} (
  `option_id` int(11) unsigned NOT NULL auto_increment,
  `path` varchar(255) NOT NULL default '',
  `text` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '1',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
    ");  
$installer->endSetup(); 
