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

namespace Sozo\ProductDownloads\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;

/**
 * Data Helper
 *
 * @package Sozo\ListingImageSwitch\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $moduleList;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context         $context
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     */
    public function __construct(
        Context $context,
        ModuleListInterface $moduleList
    )
    {
        $this->moduleList = $moduleList;
        parent::__construct($context);
    }

    /**
     * Get the installed extension version
     *
     * @return mixed
     */
    public function getExtensionVersion()
    {
        $moduleCode = 'Sozo_ProductDownloads';
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }
}
