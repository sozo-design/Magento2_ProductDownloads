<?php

namespace Sozo\ProductDownloads\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Download extends AbstractModel implements IdentityInterface
{
    /**
     * Status Enabled
     *
     * @var int
     */
    const STATUS_ENABLED = 1;

    /**
     * Status Disabled
     *
     * @var int
     */
    const STATUS_DISABLED = 0;

    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'sozo_product_downloads';

    protected $urlModel;

    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'sozo_product_downloads';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sozo_product_downloads';

    /**
     * Filter model
     *
     * @var \Magento\Framework\Filter\FilterManager
     */
    protected $filter;

    /**
     * @var string
     */
    private $uploadFolder = 'sozo/productdownloads';

    public function __construct(FilterManager $filter, Context $context, Registry $registry, AbstractResource $resource = null, AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->filter = $filter;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Prepare post's statuses.
     * Available event blog_post_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Get Download url
     *
     * @param $download
     *
     * @return string
     */
    public function getUrl($download)
    {
        return 'pub/media/' . $this->uploadFolder . $download['download_url'];
    }

    /**
     * Check if author url key exists
     * return author id if author exists
     *
     * @param string $urlKey
     * @param int    $storeId
     *
     * @return int
     */
    public function checkUrlKey($urlKey, $storeId)
    {
        return $this->_getResource()->checkUrlKey($urlKey, $storeId);
    }

    /**
     * Get downloads
     *
     * @param $downloadId
     *
     * @return bool|string
     */
    public function getDownloadsForProduct($downloadId)
    {
        return $this->getResource()->getDownloadsForProduct($downloadId);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Sozo\ProductDownloads\Model\Resource\Download');
    }
}
