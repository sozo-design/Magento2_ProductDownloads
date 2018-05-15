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

namespace Sozo\ProductDownloads\Block\Adminhtml\Product\Edit;

class Tabs extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Tabs
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->addTab(
            'downloads',
            [
                'label' => __('Downloads'),
                'content' => $this->_translateHtml(
                    $this->getLayout()->createBlock('Sozo\ProductDownloads\Block\Adminhtml\Product\Edit\Tab\Download')->toHtml()),
                'group_code' => self::BASIC_TAB_GROUP_CODE
            ]
        );
    }
}
