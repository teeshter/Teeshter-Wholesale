<?php
/**
 * Block report index
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Block\Report;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $productStatus;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $productVisibility;


    /**
     * Index constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus
     * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        array $data = []
    )
    {
        $this->productFactory = $productFactory;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        parent::__construct($context, $data);
    }

    /**
     * Retrieves products as option array
     *
     * @return array
     */
    public function getProductsOptionArray()
    {
        $options = [
            [
                'label' => '',
                'value' => '',
            ]
        ];

        $products = $this->productFactory
            ->create()
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToFilter('status',
                ['in' => $this->productStatus->getVisibleStatusIds()]
            )
            ->setVisibility($this->productVisibility->getVisibleInSiteIds())
            ->setOrder('name', 'ASC');

        foreach ($products as $product) {
            $options[] = [
                'label' => $product->getName(),
                'value' => $product->getSku(),
            ];
        }

        return $options;
    }
}
