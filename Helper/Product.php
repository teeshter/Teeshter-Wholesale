<?php
/**
 * Product helper
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Helper;

class Product extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * Product constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }

    /**
     * Validates the sku
     *  
     * @param string $sku
     * 
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function isValidSku($sku)
    {
        $product = $this->productFactory->create()->loadByAttribute('sku', $sku);

        if ($product) {
            return true;
        }

        return false;
    }
}

