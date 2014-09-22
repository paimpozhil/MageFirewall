<?php
    class MageFirewall_Firewall_Model_Mysql4_Whitelist extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('firewall/whitelist', 'whitelist_id');
        }
    }
