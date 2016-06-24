<?php

namespace Sozo\ProductDownloads\Block\Adminhtml\Product\Edit;

class Tabs extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Tabs
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->addTab('downloads', ['label' => __('Downloads'), 'content' => $this->_translateHtml($this->getLayout()->createBlock('Sozo\ProductDownload\Block\Adminhtml\Product\Edit\Tab\Download')->toHtml()), 'group_code' => self::BASIC_TAB_GROUP_CODE]);
    }
}
