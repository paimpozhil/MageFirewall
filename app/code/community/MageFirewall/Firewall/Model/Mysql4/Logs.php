<?php
    class MageFirewall_Firewall_Model_Mysql4_Logs extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('firewall/logs', 'log_id');
        }
    }
