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

namespace Sozo\ProductDownloads\Controller\Adminhtml\Delete\Index;

use Magento\Framework\App\Action\Action;
use Sozo\ProductDownloads\Model\Download;
use Sozo\ProductDownloads\Model\DownloadFactory;

class Index extends Action
{
    private $download;

    private $downloadFactory;

    public function __construct(\Magento\Backend\App\Action\Context $context, Download $download, DownloadFactory $downloadFactory)
    {
        $this->download = $download;
        $this->downloadFactory = $downloadFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($downloadId = $_GET['download_id']) {
            $name = "";
            try {
                /** @var \Sozo\ProductDownloads\Model\Download $download */
                $download = $this->downloadFactory->create();
                $download->load($downloadId);
                $name = $download->getName();
                $productId = $download['product_id'];
                $download->delete();
                $this->messageManager->addSuccess(__('The download has been deleted.'));
                $this->_eventManager->dispatch(
                    'adminhtml_sozo_productdownloads_download_on_delete',
                    [
                        'name' => $name,
                        'status' => 'success'
                    ]
                );
                $resultRedirect->setPath('catalog/product/edit/*', ['id' => $productId, 'active_tab' => 'downloads']);
                return $resultRedirect;
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_sozo_productdownloads_delete_on_delete',
                    [
                        'name' => $name,
                        'status' => 'fail'
                    ]
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                $resultRedirect->setPath('catalog/product/edit/', ['id' => $productId, 'active_tab' => 'downloads']);
                return $resultRedirect;
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a download to delete.'));
        // go to grid
        $resultRedirect->setPath('catalog/product/index');
        return $resultRedirect;
    }
}
