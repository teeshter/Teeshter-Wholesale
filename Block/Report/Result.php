<?php
/**
 * Block report result
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Block\Report;

class Result extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Sales\Model\Order\ItemFactory
     */
    protected $orderItemFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var string
     */
    protected $sku;


    /**
     * Result constructor
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\Order\ItemFactory $orderItemFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\Order\ItemFactory $orderItemFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    )
    {
        $this->orderItemFactory = $orderItemFactory;
        $this->productFactory = $productFactory;
        $this->request = $request;
        $this->sku = $this->request->getParam('sku');
        parent::__construct($context, $data);
    }

    /**
     * Retrieves product name
     *
     * @return string
     */
    public function getProductName()
    {
        $productName = '';
        $product = $this->productFactory
            ->create()
            ->loadByAttribute('sku', $this->sku);

        if ($product) {
            $productName = $product->getName();
        }

        return $productName;
    }

    /**
     * Retrieves total quantity sold
     *
     * @return int
     */
    public function getTotalQtySold()
    {
        $totalQtySold = 0;

        $orderItems = $this->orderItemFactory
            ->create()
            ->getCollection()
            ->addFieldToSelect('sku')
            ->addFieldToSelect('qty_ordered')
            ->addFieldToFilter('sku', ['eq' => $this->sku])
            ->addFieldToFilter('parent_item_id', ['null' => true]);

        foreach ($orderItems as $orderItem) {
            $totalQtySold += $orderItem->getQtyOrdered();
        }

        return $totalQtySold;
    }
}
