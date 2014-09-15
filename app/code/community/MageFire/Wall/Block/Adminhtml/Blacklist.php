<?php
    class MageFire_Wall_Block_Adminhtml_Blacklist extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_blacklist';
            $this->_blockGroup = 'wall';
            $this->_headerText = Mage::helper('wall')->__('Black List');
            parent::__construct();
        }
    }
