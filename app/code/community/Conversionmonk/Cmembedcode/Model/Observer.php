<?php
class Conversionmonk_Cmembedcode_Model_Observer
{
    public function newsletterSubscriberChange(Varien_Event_Observer $observer)
    {
        $subscriber = $observer->getEvent()->getSubscriber();
        $data = Mage::app()->getRequest()->getParams() ? Mage::app()->getRequest()->getParams() : array();
        
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            
            if (isset($data['email']) && $customer->getEmail() === $data['email']) {
               
                if (!Mage::getStoreConfig('cmembedcode/fields/customer_override')) {
                    $data['firstname'] = '';
                    $data['lastname'] = '';
					$data['subscriber_source'] = '';
                }

            }
        }
        
        // store data only if email is provided
        if (isset($data['email'])) {
            //$data['firstname'] = 'testfirst1';
			/*echo "<pre />";
			print_r($data);
			die;*/
			if (isset($data['firstname'])) $subscriber->setCmonkSubscriberFirstname($data['firstname']);
            if (isset($data['lastname'])) $subscriber->setCmonkSubscriberLastname($data['lastname']);
			if (isset($data['subscriber_source'])) $subscriber->setCmonkSubscriberSource($data['subscriber_source']);
        }
        
        return $this;
    }
}