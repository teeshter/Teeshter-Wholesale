<?php
/**
 * Abstract controller report
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Controller;

abstract class Report extends \Magento\Framework\App\Action\Action
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
     * Report constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * Checks customer authentication
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * 
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $isAuthenticated = $this->customerSession->authenticate();

        if (!$isAuthenticated
            || ($isAuthenticated
                && $this->customerSession->getCustomer()->getGroupId() != self::CUSTOMER_GROUP_WHOLESALE_ID)
        ) {
            $this->_actionFlag->set('', 'no-dispatch', true);
            if (!$this->customerSession->getBeforeUrl()) {
                $this->customerSession->setBeforeUrl($this->_redirect->getRefererUrl());
            }
        }

        return parent::dispatch($request);
    }
}
