<?php
class Conversionmonk_Cmembedcode_Adminhtml_Block_Newsletter_Subscriber_Grid extends Mage_Adminhtml_Block_Newsletter_Subscriber_Grid
{
	protected function _prepareCollection()
	{
        $collection = Mage::getResourceSingleton('newsletter/subscriber_collection');
        $collection->showCustomerInfo();
        
        $collection->addSubscriberTypeField()
            ->showStoreInfo();

        if($this->getRequest()->getParam('queue', false)) {
            $collection->useQueue(Mage::getModel('newsletter/queue')
                ->load($this->getRequest()->getParam('queue')));
        }

        $this->setCollection($collection);
		
        if ($this->getCollection()) {

            $this->_preparePage();

            $columnId = $this->getParam($this->getVarNameSort(), $this->_defaultSort);
            $dir      = $this->getParam($this->getVarNameDir(), $this->_defaultDir);
            $filter   = $this->getParam($this->getVarNameFilter(), null);

            if (is_null($filter)) {
                $filter = $this->_defaultFilter;
            }

            if (is_string($filter)) {
                $data = $this->helper('adminhtml')->prepareFilterString($filter);
                $this->_setFilterValues($data);
            }
            else if ($filter && is_array($filter)) {
                $this->_setFilterValues($filter);
            }
            else if(0 !== sizeof($this->_defaultFilter)) {
                $this->_setFilterValues($this->_defaultFilter);
            }

            if (isset($this->_columns[$columnId]) && $this->_columns[$columnId]->getIndex()) {
                $dir = (strtolower($dir)=='desc') ? 'desc' : 'asc';
                $this->_columns[$columnId]->setDir($dir);
                $this->_setCollectionOrder($this->_columns[$columnId]);
            }

            if (!$this->_isExport) {
                $this->getCollection()->load();
                $this->_afterLoadCollection();
            }
        }
    }

	protected function _prepareColumns()
	{
		parent::_prepareColumns();
		
        $this->mrRemoveColumn('firstname');
        $this->mrRemoveColumn('lastname');
		
		
		$this->addColumnAfter('firstname', array(
			'header'    => Mage::helper('newsletter')->__('First Name'),
            'index'     => 'customer_firstname',
			'renderer'	=> 'Conversionmonk_Cmembedcode_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Firstname'
		), Mage::getStoreConfig('newsletterextended/fields/show_prefix') ? 'prefix' : (Mage::getStoreConfig('newsletterextended/fields/show_gender') ? 'gender' : 'type'));
		
		$this->addColumnAfter('lastname', array(
			'header'    => Mage::helper('newsletter')->__('Last Name'),
            'index'     => 'customer_lastname',
			'renderer'	=> 'Conversionmonk_Cmembedcode_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Lastname'
		), 'firstname');
		
		$this->addColumnAfter('cmonk_subscriber_source', array(
			'header'    => Mage::helper('newsletter')->__('Source'),
            'index'     => 'cmonk_subscriber_source'
		), 'lastname');


		// manually sort again, that our custom order works
		$this->sortColumnsByOrder();
		
        return $this;
    }

    public function mrRemoveColumn($columnId)
    {
        if (method_exists($this, "removeColumn")) {
            return $this->removeColumn($columnId);
        }
        else if (isset($this->_columns[$columnId])) {
            unset($this->_columns[$columnId]);
            if ($this->_lastColumnId == $columnId) {
                $this->_lastColumnId = key($this->_columns);
            }
        }
        return $this;
    }

}
