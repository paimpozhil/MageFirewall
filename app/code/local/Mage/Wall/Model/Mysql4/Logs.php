<?php
    class Mage_Wall_Model_Mysql4_Logs extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('wall/logs', 'log_id');
        }
    }
