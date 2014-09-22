<?php
    class MageFirewall_Firewall_Model_Mysql4_Options extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('firewall/options', 'option_id');
        }
    }
