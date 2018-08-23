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
 * @copyright   Copyright (c) 2018 SOZO Design (https://sozodesign.co.uk)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

namespace Sozo\ProductDownloads\Block\System\Config\Form\Fieldset;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Module\ModuleList\Loader;
use Sozo\ProductDownloads\Helper\Data;

class Hint extends Template implements RendererInterface
{
    /**
     * @var \Sozo\ProductDownloads\Helper\Data
     */
    private $helper;

    /**
     * @var string
     */
    protected $_template = 'Sozo_ProductDownloads::system/config/fieldset/hint.phtml';

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $metaData;

    /**
     * @var \Magento\Framework\Module\ModuleList\Loader
     */
    private $loader;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetaData
     * @param \Magento\Framework\Module\ModuleList\Loader $loader
     * @param \Sozo\ProductDownloads\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductMetadataInterface $productMetaData,
        Loader $loader,
        Data $helper,
        array $data = []
    ) {

        parent::__construct($context, $data);
        $this->metaData = $productMetaData;
        $this->loader = $loader;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return mixed
     */
    public function render(AbstractElement $element)
    {
        return $this->toHtml();
    }

    /**
     * @return string
     */
    public function getPxParams()
    {
        $v = $this->helper->getExtensionVersion();
        $extension = "ProductDownloads;{$v}";
        $mageEdition = $this->metaData->getEdition();
        switch ($mageEdition) {
            case 'Community':
                $mageEdition = 'CE';
                break;
            case 'Enterprise':
                $mageEdition = 'EE';
                break;
        }
        $mageVersion = $this->metaData->getVersion();
        $mage = "Magento {$mageEdition};{$mageVersion}";
        $hash = md5($extension . '_' . $mage . '_' . $extension);
        return "ext=$extension&mage={$mage}&ctrl={$hash}";
    }

    /**
     * Get the currently installed version of the plugin
     *
     * @return mixed
     */
    public function getVersion()
    {
        return $this->helper->getExtensionVersion();
    }
}
