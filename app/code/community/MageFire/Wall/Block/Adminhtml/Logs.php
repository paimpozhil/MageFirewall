<?php
    class MageFire_Wall_Block_Adminhtml_Logs extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        public function __construct()
        {
            $this->_controller = 'adminhtml_logs';
            $this->_blockGroup = 'wall';
            $this->_headerText = Mage::helper('wall')->__('Logs');
            parent::__construct();            
            $this->_removeButton('add');
        }
    }
