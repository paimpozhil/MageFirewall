<?php
    class MageFirewall_Firewall_Model_Mysql4_Version extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('firewall/version', 'version_id');
        }
    }
