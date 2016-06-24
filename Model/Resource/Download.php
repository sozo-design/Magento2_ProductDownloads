<?php

namespace Sozo\ProductDownloads\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;

class Download extends AbstractDb
{
    /**
     * \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    public function __construct(Context $context, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Stdlib\DateTime $dateTime, $resourcePrefix = null)
    {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    public function load(AbstractModel $object, $value, $field = null)
    {
        if (! is_numeric($value) && is_null($field)) {
            $field = 'product_id';
        }

        return parent::load($object, $value, $field);
    }

    public function getDownloadsForProduct($id)
    {
        $adapter = $this->getConnection();

        $select = $adapter->select()->from($this->getMainTable())->where('product_id = :product_id');
        $binds = ['product_id' => (int) $id];

        return $adapter->fetchAll($select, $binds);
    }

    public function checkUrlKey($urlKey, $storeId)
    {
        $stores = [Store::DEFAULT_STORE_ID, $storeId];
        $select = $this->_getLoadByUrlKeySelect($urlKey, $stores, 1);
        $select->reset(\Zend_Db_Select::COLUMNS)->columns('download_id')->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    protected function _construct()
    {
        $this->_init('sozo_product_downloads', 'download_id');
    }

    protected function _beforeSave(AbstractModel $object)
    {
        return parent::_beforeSave($object);
    }

    protected function _beforeDelete(AbstractModel $object)
    {
        $condition = ['download_id = ?' => (int) $object->getId()];
        $this->getConnection()->delete($this->getTable('sozo_product_downloads'), $condition);

        return parent::_beforeDelete($object);
    }
}
