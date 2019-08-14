<?php
class Conversionmonk_Cmembedcode_Model_Subscriber extends Mage_Newsletter_Model_Subscriber
{
    protected $customer;
    
    public function getCustomer()
    {
        if (!isset($this->customer)) {
            $this->customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
        }        
        return $this->customer;
    }    
   
}