<?php
/**
 * SOZO Design
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category    SOZO Design
 * @package     Sozo_ProductDownloads
 * @copyright   Copyright (c) 2018 SOZO Design (https://sozodesign.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

namespace Sozo\ProductDownloads\Block\Adminhtml\Product\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Sozo\ProductDownloads\Model\Download as DownloadModel;

class Download extends \Magento\Backend\Block\Widget
{
    const URL_PATH_DELETE = 'downloads/delete';

    protected $_template = 'product/tab/download.phtml';

    protected $coreRegistry;
    protected $defaultMimeTypes = ['pdf', 'doc', 'docx', 'rtf', 'txt', 'csv', 'xlsx', 'xls', 'jpg', 'jpeg', 'png', 'gif', 'zip'];

    private $download;

    public function __construct(Context $context, Registry $coreRegistry, DownloadModel $download, array $data = [])
    {
        $this->coreRegistry = $coreRegistry;
        $this->download = $download;
        parent::__construct($context, $data);
    }

    public function isReadonly()
    {
        return $this->getProduct()->getInventoryReadonly();
    }

    public function getProduct()
    {
        return $this->coreRegistry->registry('product');
    }

    public function isNew()
    {
        if ($this->getProduct()->getId()) {
            return false;
        }
        return true;
    }

    public function getFieldSuffix()
    {
        return 'product';
    }

    public function isVirtual()
    {
        return $this->getProduct()->getIsVirtual();
    }

    public function getDownloads()
    {
        return $this->download->getResource()->getDownloadsForProduct($this->getProduct()->getId());
    }

    public function getDownloadUrl($download)
    {
        return $this->getBaseUrl() . $this->download->getUrl($download);
    }

    public function getDeleteUrl($downloadID)
    {
        return $this->_urlBuilder->getUrl(static::URL_PATH_DELETE) . '?download_id=' . $downloadID;
    }

    public function getExtensions()
    {
        $mimeTypes = $this->_scopeConfig->getValue('sozo_productdownloads/general/extension');
        return $mimeTypes;
    }
}
