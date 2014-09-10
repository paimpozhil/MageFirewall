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
		$days = $this->getOptionsData('show_recent_file_days');
		$lists[0] = $days;
		exec('find . -iregex ".*\(html\|php\)" -mtime -'.$lists[0],$lists[1]);
		$lists[1] = implode("<br />", $lists[1]);
		return $lists;		
	}
	
	public function getClientIp(){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;		
	}
	
	public function getOptionsData($fieldtext){
		$optiosData = Mage::getModel('wall/options')->getCollection()->addFieldToFilter('path',$fieldtext)->getData();		
		return  $optiosData[0]['value'];
	}
	
	
}
?>
