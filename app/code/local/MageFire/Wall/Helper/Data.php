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
	
	public function getMageEmail(){
		return Mage::getStoreConfig('trans_email/ident_general/email');		
	}
	
	public function getRecentEditedFiles(){
		$days = Mage::getModel('wall/options')->getCollection()->addFieldToFilter('option_id',4)->getData();
		$lists[0] = $days[0]['value'];
		exec('find . -iregex ".*\(html\|php\)" -mtime -'.$lists[0],$lists[1]);
		$lists[1] = implode("<br />", $lists[1]);
		return $lists;		
	}
	
}
?>
