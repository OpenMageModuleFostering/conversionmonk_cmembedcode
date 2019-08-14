<?php
class Conversionmonk_Cmembedcode_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Firstname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
        // not logged in => use subscriber data
        if ($row->getType() != 2) {
            $value = $row->getCmonkSubscriberFirstname();
        }
        // logged-in with override
        elseif (Mage::getStoreConfig('cmembedcode/fields/customer_override')) {
            
            // fallback enabled => fallback to customer data if no data found in subscriber
            if (Mage::getStoreConfig('cmembedcode/fields/customer_fallback')) {
                $value = $row->getCmonkSubscriberFirstname() ? $row->getCmonkSubscriberFirstname() : $row->getCustomerFirstname();
            }
            // fallback disabled => only use subscriber data event if it's empty
            else {
                $value = $row->getCmonkSubscriberFirstname();
            }
        }
        // logged-in without override => only use customer data even if it's empty
        else {
            $value = $row->getCustomerFirstname();
        }
		
		return $value ? $value : '---';
	}
}