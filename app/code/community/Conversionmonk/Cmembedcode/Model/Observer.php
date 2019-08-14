<?php
class Conversionmonk_Cmembedcode_Model_Observer
{
    public function newsletterSubscriberChange(Varien_Event_Observer $observer)
    {
        $subscriber = $observer->getEvent()->getSubscriber();
        $data = Mage::app()->getRequest()->getParams() ? Mage::app()->getRequest()->getParams() : array();
        
       
        
        // store data only if email is provided
		if (isset($data['showcolumn'])){
			$configValueEnabled = $data['showcolumn'];
		}
		
        if (isset($data['email'])) {         
			if (isset($data['subscriber_source'])) $subscriber->setCmonkSubscriberSource($data['subscriber_source']);
			if($configValueEnabled != '') {
				$configSwitch = new Mage_Core_Model_Config();
				$configSwitch ->saveConfig('csettings/gcsettings/showcolumn', $data['showcolumn'], 'default', 0);
			}
        }
        
        return $this;
    }
}