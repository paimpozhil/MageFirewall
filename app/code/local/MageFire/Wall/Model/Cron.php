<?php

class MageFire_Wall_Model_Cron extends Varien_Object
{	
	public function deleteOldLogs()
    { 
		$wallHelper = Mage::helper('wall');
		$date = date('Y-m-j G:i:s') ; 
		$LogDeleteDate = strtotime ( '-'.$this->getLogDays().' day' , strtotime ( $date ) ) ; 
		$LogDeleteDate = date ( 'Y-m-j' , $LogDeleteDate ) ; 
		$model = Mage::getModel('wall/logs')->getCollection();
		$model->addFieldToFilter('created_time',array(
				array(
					'to' => $LogDeleteDate,
					'date' => true, 
					),
				));
		$Logs = $model->getData();
		if($Logs){ 
			foreach($Logs as $logId){
				$model = Mage::getModel('wall/logs');
				$model->setId(trim($logId['log_id']))
					  ->delete();					  
				}
		}	
		$editedFiles = $wallHelper->getRecentEditedFiles();
		$this->notify('admin user',$wallHelper->getMageEmail(),'Last Modified Email Notify',$editedFiles[1]);
		return;
	}
	
	public function getLogDays()
    { 
		return Mage::getStoreConfig('system/log/clean_after_day');
	}
	
	public function notify($sendToName, $sendToEmail, $subject, $msg) { 
		Mage::log("Sending email to $sendTo");	 
		$mail = Mage::getModel('core/email');
		$mail->setToName($sendToName);
		$mail->setToEmail($sendToEmail);
		$mail->setBody($msg);
		$mail->setSubject('=?utf-8?B?'.base64_encode($subject).'?=');
		$mail->setFromEmail("infp@magefirewall.com");
		$mail->setFromName("MageFirewall");
		$mail->setType('text');
	 
		try {
			$mail->send();
		}
		catch (Exception $e) {
			Mage::logException($e);
			return false;
		}
	 
		return true;
	}
    
}
?>
