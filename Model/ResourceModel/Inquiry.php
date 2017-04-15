<?php
/**
 * Resource model inquiry
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Model\ResourceModel;

class Inquiry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('teeshter_wholesale_inquiry', 'inquiry_id');
    }
}
