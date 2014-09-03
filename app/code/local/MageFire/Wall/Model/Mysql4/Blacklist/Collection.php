<?php
    class MageFire_Wall_Model_Mysql4_Blacklist_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {
        public function _construct()
        {  
            $this->_init('wall/blacklist');
        }
    }
