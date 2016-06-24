<?php

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
        if( $downloadId = $_GET['download_id'] ) {
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
