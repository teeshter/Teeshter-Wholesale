<?php
/**
 * Observer for adding not wholesale layout handle
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Observer;

class AddNotWholesaleLayoutHandle implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Customer group wholesale ID
     */
    const CUSTOMER_GROUP_WHOLESALE_ID = 2;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;


    /**
     * AddNotWholesaleLayout constructor
     * 
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * Adds layout handle for customers who are not wholesale
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->customerSession->getCustomer()->getGroupId() != self::CUSTOMER_GROUP_WHOLESALE_ID) {
            $layout = $observer->getData('layout');
            $layout->getUpdate()->addHandle('customer_not_wholesale');
        }
    }
}
