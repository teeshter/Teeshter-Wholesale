<?php
/**
 * Controller report result
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Controller\Report;

class Result extends \Teeshter\Wholesale\Controller\Report
{
    /**
     * @var \Teeshter\Wholesale\Helper\Product
     */
    protected $productHelper;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Teeshter\Wholesale\Model\InquiryFactory
     */
    protected $inquiryFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;


    /**
     * Result constructor
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Teeshter\Wholesale\Helper\Product $productHelper
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Teeshter\Wholesale\Model\InquiryFactory $inquiryFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Teeshter\Wholesale\Helper\Product $productHelper,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Teeshter\Wholesale\Model\InquiryFactory $inquiryFactory,
                                \Magento\Customer\Model\Session $customerSession,
                                \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
                                \Magento\Framework\Stdlib\DateTime $dateTime
    ) {
        $this->productHelper = $productHelper;
        $this->resultPageFactory = $resultPageFactory;
        $this->inquiryFactory = $inquiryFactory;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->scopeConfig = $scopeConfig;
        $this->dateTime = $dateTime;
        parent::__construct($context, $customerSession);
    }

    /**
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setRefererUrl();
        }

        $sku = $this->getRequest()->getParam('sku');

        if (!$this->productHelper->isValidSku($sku)) {
            $this->messageManager->addErrorMessage(__('Invalid product submitted'));
            return $this->resultRedirectFactory->create()->setRefererUrl();
        }

        try {
            $isLogEnabled = $this->scopeConfig->getValue('teeshter_wholesale/log/enabled', 
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            if ($isLogEnabled) {
                $log = $this->inquiryFactory->create();
                $log->setCustomerId($this->customerSession->getCustomerId())
                    ->setProductSku($sku)
                    ->setCreatedAt($this->dateTime->formatDate(true))
                    ->save();
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred during report generation'));
            return $this->resultRedirectFactory->create()->setRefererUrl();
        }

        return $this->resultPageFactory->create();
    }
}
