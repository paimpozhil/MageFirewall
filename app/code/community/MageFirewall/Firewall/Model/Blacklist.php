<?php     
    class MageFirewall_Firewall_Model_Blacklist extends Mage_Core_Model_Abstract
    {
        public function _construct()
        {
            parent::_construct();
            $this->_init('firewall/blacklist');
        }
    }
?>
