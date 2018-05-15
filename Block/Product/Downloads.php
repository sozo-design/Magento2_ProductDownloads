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

namespace Sozo\ProductDownloads\Block\Product;

use Magento\Framework\View\Element\Template;
use Sozo\ProductDownloads\Model\Download;

class Downloads extends Template
{

    /**
     * @var Download
     */
    private $download;
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param Download $download
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        Download $download)
    {
        $this->download = $download;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);

        $this->setTabTitle();
    }

    /**
     * Set tab title
     *
     * @return void
     */
    public function setTabTitle()
    {
        $this->setTitle(__('Downloads'));
    }

    /**
     * Return Downloads
     *
     * @return mixed
     */
    public function getDownloads()
    {
        return $this->download->getDownloadsForProduct($this->getProduct()->getId());
    }

    /**
     * Return current product instance
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->coreRegistry->registry('product');
    }

    /**
     * @param $download
     *
     * @return string
     */
    public function getDownloadUrl($download)
    {
        // @TODO - index.php weghalen
        return str_replace('index.php', '', $this->getBaseUrl()) . $this->download->getUrl($download);
    }
}
