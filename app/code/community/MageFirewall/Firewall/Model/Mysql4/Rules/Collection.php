<?php
    class MageFirewall_Firewall_Model_Mysql4_Rules_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {
        public function _construct()
        {  
            $this->_init('firewall/rules');
        }
    }
