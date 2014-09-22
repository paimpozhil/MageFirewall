<?php
    class MageFirewall_Firewall_Model_Mysql4_Version_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {
        public function _construct()
        {
            $this->_init('firewall/version');
        }
    }
