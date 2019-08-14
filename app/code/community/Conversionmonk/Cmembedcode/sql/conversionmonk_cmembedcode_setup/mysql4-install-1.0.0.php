<?php
$installer = $this;
$installer->startSetup();

// add additional columns to "newsletter_subscriber" table
$tableName = $installer->getTable('newsletter_subscriber');

$installer->getConnection()->addColumn($tableName, 'cmonk_subscriber_source', array(
    'nullable' => true,
    'length' => 255,
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment' => 'added by conversionmonk'
));


$installer->endSetup();