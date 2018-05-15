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

namespace Sozo\ProductDownloads\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Validator\Exception;
use Magento\Framework\Filesystem;
use Magento\Framework\File\Uploader;

class Upload
{
    /**
     * Uploader factory
     *
     * @var \Magento\Framework\File\UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var string
     */
    private $uploadPath;

    /**
     * @var string
     */
    private $uploadFolder = 'sozo/productdownloads';

    /**
     * @var ScopeConfigInterface
     */
    private $_scopeConfig;

    public function __construct(UploaderFactory $uploaderFactory, Filesystem $filesystem, ScopeConfigInterface $scopeConfig)
    {
        $this->uploaderFactory = $uploaderFactory;
        $this->uploadPath = $filesystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath($this->uploadFolder);
        $this->_scopeConfig = $scopeConfig;
    }

    public function uploadFile($download)
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $download]);
            $uploader->setAllowedExtensions($this->getMimeTypes());
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);

            $result = $uploader->save($this->uploadPath);

            return $result;
        } catch (\Exception $e) {
            if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                throw new Exception(__('Disallowed file type, only these file types are allowed: %s.' . implode(', ', $this->getMimeTypes())));
            }
        }

        return false;
    }

    private function getMimeTypes()
    {
        $mimeTypes = $this->_scopeConfig->getValue('sozo_productdownloads/general/extension');

        $cleanMimeTypes = [];

        foreach (explode(',', $mimeTypes) as $mimeType) {
            array_push($cleanMimeTypes, strtolower(trim($mimeType)));
        }

        return $cleanMimeTypes;
    }
}
