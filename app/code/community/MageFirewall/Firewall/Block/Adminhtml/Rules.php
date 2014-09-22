<?php
    class MageFirewall_Firewall_Block_Adminhtml_Rules extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_rules';
            $this->_blockGroup = 'firewall';
            $this->_headerText = Mage::helper('firewall')->__('Rules List');
            parent::__construct();            
            $this->_removeButton('add');
        }
    }
