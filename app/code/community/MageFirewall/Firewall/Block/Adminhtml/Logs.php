<?php
    class MageFirewall_Firewall_Block_Adminhtml_Logs extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_logs';
            $this->_blockGroup = 'firewall';
            $this->_headerText = Mage::helper('firewall')->__('Logs');
            parent::__construct();            
            $this->_removeButton('add');
        }
    }
