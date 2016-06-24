<?php
/**
 *   Copyright (c) 2016 SOZO Design. All rights reserved.
 */

namespace Sozo\ProductDownloads\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class:InstallSchema
 * Sozo\ProductDownloads\Setup
 *
 * @author      Clive Walkden
 * @package     Sozo\ProductDownloads
 * @copyright   Copyright (c) 2016, SOZO Design. All rights reserved
 */
class InstallSchema implements InstallSchemaInterface {

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'downloadable_link'
         */
        $table = $installer->
                    getConnection()->
                    newTable($installer->getTable('sozo_product_downloads'))->
                    addColumn(
                        'download_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null, [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],
                        'Download ID'
                    )->
                    addColumn(
                        'product_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null, [
                            'unsigned' => true,
                            'nullable' => false,
                            'default' => '0'
                        ],
                        'Product ID'
                    )->
                    addColumn(
                        'number_of_downloads',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null, [
                            'nullable' => true
                        ],
                        'Number of downloads'
                    )->
                    addColumn('download_url',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Download Url'
                    )->
                    addColumn('download_file',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Download File'
                    )->
                    addColumn('download_type',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        20,
                        [],
                        'Download Type'
                    )->
                    addIndex($installer->getIdxName('sozo_product_downloads', ['product_id']), ['product_id'])->
                    setComment('Product downloads table');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
