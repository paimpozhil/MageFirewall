<?php
    class MageFirewall_Firewall_Model_Mysql4_Blacklist extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('firewall/blacklist', 'blacklist_id');
        }
    }
