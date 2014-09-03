<?php
    class MageFire_Wall_Model_Mysql4_Blacklist extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('wall/blacklist', 'blacklist_id');
        }
    }
