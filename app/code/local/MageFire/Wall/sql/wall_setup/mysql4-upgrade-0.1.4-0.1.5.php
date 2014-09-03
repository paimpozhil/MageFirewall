<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('wall/rules'), 'who',
    "VARCHAR(255) NOT NULL DEFAULT '' AFTER `title`");
$installer->getConnection()->addColumn($installer->getTable('wall/rules'), 'where',
    "VARCHAR(255) NOT NULL DEFAULT '' AFTER `title`");
$installer->getConnection()->addColumn($installer->getTable('wall/rules'), 'what',
    "VARCHAR(255) NOT NULL DEFAULT '' AFTER `title`");
$installer->getConnection()->addColumn($installer->getTable('wall/rules'), 'why',
    "VARCHAR(255) NOT NULL DEFAULT '' AFTER `title`");
$installer->getConnection()->addColumn($installer->getTable('wall/rules'), 'level',
    "VARCHAR(255) NOT NULL DEFAULT '' AFTER `title`");    
$installer->getConnection()->addColumn($installer->getTable('wall/rules'), 'level',
    "VARCHAR(255) NOT NULL DEFAULT '' AFTER `enabled`");          
$installer->endSetup();
