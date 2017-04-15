<?php
/**
 * Resource model inquiry collection
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Model\ResourceModel\Inquiry;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Teeshter\Wholesale\Model\Inquiry', 'Teeshter\Wholesale\Model\ResourceModel\Inquiry');
    }
}
