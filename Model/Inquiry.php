<?php
/**
 * Model inquiry
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Model;

class Inquiry extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Teeshter\Wholesale\Model\ResourceModel\Inquiry');
    }
}
