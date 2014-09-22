<?php     
    class MageFirewall_Firewall_Model_Whitelist extends Mage_Core_Model_Abstract
    {
        public function _construct()
        {
            parent::_construct();
            $this->_init('firewall/whitelist');
        }
    }
?>
