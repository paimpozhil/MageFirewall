<?php
    class MageFirewall_Firewall_Block_Adminhtml_Whitelist extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_whitelist';
            $this->_blockGroup = 'firewall';
            $this->_headerText = Mage::helper('firewall')->__('White List');
            parent::__construct();
        }
    }
