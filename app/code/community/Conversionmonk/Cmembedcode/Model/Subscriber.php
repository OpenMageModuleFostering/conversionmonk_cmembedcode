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

    public function getSubscriberFirstname()
    {
        $firstname = parent::getCmonkSubscriberFirstname();
        
        if (!$firstname && $this->getCustomer()) {
            $firstname = $this->getCustomer()->getFirstname();
        }
        return $firstname;
    }
    
    public function getSubscriberLastname()
    {
        $lastname = parent::getCmonkSubscriberLastname();
        
        if (!$lastname && $this->getCustomer()) {
            $lastname = $this->getCustomer()->getLastname();
        }
        return $lastname;
    }

    public function getSubscriberFullName()
    {
        return trim($this->getCmonkSubscriberFirstname() . ' ' . $this->getCmonkSubscriberLastname());
    }
    

    

    
   
}