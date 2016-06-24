<?php

namespace Sozo\ProductDownloads\Model\Adminhtml\Download;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Sozo\ProductDownloads\Model\Upload;
use Magento\Framework\Event\Observer as EventObserver;

class Observer implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var Sozo\ProductDownloads\Model\Upload
     */
    private $upload;

    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private $context;

    public function __construct(Registry $registry, Upload $upload, Context $context)
    {
        $this->coreRegistry = $registry;
        $this->upload = $upload;
        $this->context = $context;
    }

    public function execute(EventObserver $observer)
    {
        $downloads = $this->context->getRequest()->getFiles('downloads', -1);

        if ($downloads != '-1') {
            $product = $this->coreRegistry->registry('product');
            $productId = $product->getId();

            foreach ($downloads as $download) {

                $uploadedDownload = $this->upload->uploadFile($download);

                if ($uploadedDownload) {
                    $objectManager = $this->context->getObjectManager();

                    $download = $objectManager->create('Sozo\ProductDownloads\Model\Download');

                    $download->setDownloadUrl($uploadedDownload['file']);
                    $download->setDownloadFile($uploadedDownload['name']);
                    $download->setDownloadType($uploadedDownload['type']);
                    $download->setProductId($productId);
                    $download->save();
                }
            }
        }

        return $this;
    }
}
