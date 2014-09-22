<?php
    class MageFirewall_Firewall_Block_Adminhtml_Blacklist extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_blacklist';
            $this->_blockGroup = 'firewall';
            $this->_headerText = Mage::helper('firewall')->__('Black List');
            parent::__construct();
        }
    }
