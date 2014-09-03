<?php
    class MageFire_Wall_Block_Adminhtml_Whitelist extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_whitelist';
            $this->_blockGroup = 'wall';
            $this->_headerText = Mage::helper('wall')->__('White List');
            parent::__construct();
        }
    }
