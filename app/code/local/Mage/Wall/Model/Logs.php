<?php     
    class Mage_Wall_Model_Logs extends Mage_Core_Model_Abstract
    {
        public function _construct()
        {
            parent::_construct();
            $this->_init('wall/logs');
        }
    }
?>
