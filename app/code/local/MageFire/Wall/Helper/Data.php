<?php
class MageFire_Wall_Helper_Data extends Mage_Core_Helper_Abstract
{	
	public function getLogsCount(){
		$currentMonth=date("Y-m");
		$recentLogs = Mage::getModel('wall/logs')->getCollection();
		$recentLogs->addFieldToFilter('created_time', array('like' =>"%2014-09%"));
		$LogsCount = $recentLogs->getData();
		return count($LogsCount);
		
	}
}
?>
