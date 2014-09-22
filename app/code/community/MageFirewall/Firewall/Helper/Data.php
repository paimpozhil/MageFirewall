<?php
class MageFirewall_Firewall_Helper_Data extends Mage_Core_Helper_Abstract
{	
	public function getLogsCount(){
		$currentMonth=date("Y-m");
		$recentLogs = Mage::getModel('firewall/logs')->getCollection();
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
		$optiosData = Mage::getModel('firewall/options')->getCollection()->addFieldToFilter('path',$fieldtext)->getData();		
		return  $optiosData[0]['value'];
	}
	
	// file checker function start
	// Check for string in file return bool
	public function isinfile($stringtofind,$path) {
		if(!file_exists($path)) {
			return false; // if no file then where would be the exploitation in it :P
		}
		$openedfile = file_get_contents($path);
		if(strpos($openedfile, $stringtofind) !== FALSE)
		{
			// found in file
			return true;
		}
		else
		{
			// Not found in file
			return false;
		}
	}
	
	//Printing function for logging function no return
	public function printer($type=2,$printstring) {
		if($type == 1) {
			echo "<br /><h3>$printstring</h3>";
		}
		else if($type == 2) {
			echo "<br />$printstring";
		}
	}
	
	public function startprocess($collectiontocheck) {
		$errorflag = 0;
		$this->printer(1,$collectiontocheck['exploitname']);
		foreach($collectiontocheck['data'] as $check) {
			if($this->isinfile($check['searchstring'],$check['filelocation'])) {
				$errorflag = 0;
			}
		}
		$results[]['name'] = $collectiontocheck['exploitname'];
		if($errorflag == 1) {
			$this->printer(2,$collectiontocheck['error']);
			$results[]['status'] = "fail";
		}
		else {
			$results[]['status'] = "pass";
		}
	}
	// file checker function start end
}
?>
