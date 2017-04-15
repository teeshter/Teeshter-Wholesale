<?php
/**
 * Block adminhtml inquiry
 *
 * @category    Teeshter
 * @package     Teeshter_Wholesale
 * @author      teeshter
 */
namespace Teeshter\Wholesale\Block\Adminhtml;

class Inquiry extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'Teeshter_Wholesale';
        $this->_headerText = __('Inquiries');
        parent::_construct();
        $this->removeButton('add');
    }
}
