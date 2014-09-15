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
		$this->notify('admin user',$this->getSenderEmail(),'Magento store - MageFirewal',$editedFiles[1]);
		return;
	}
	
	public function getSenderEmail()
    { 
		$sendToEmail = Mage::helper('wall')->getMageEmail();
		if(Mage::helper('wall')->getOptionsData('email_addresss')) { 
			$sendToEmail = Mage::helper('wall')->getOptionsData('email_addresss');			
		}
		return $sendToEmail;
	}
	
	public function getLogDays()
    { 
		return Mage::getStoreConfig('system/log/clean_after_day');
	}
	
	public function notify($sendToName, $sendToEmail, $subject, $msg) { 
		$mail = Mage::getModel('core/email');
		$mail->setToName($sendToName);
		$mail->setToEmail($sendToEmail);
		$mail->setBody($msg);
		$mail->setSubject($subject);
		$mail->setFromEmail(Mage::getStoreConfig('trans_email/ident_general/email'));
		$mail->setFromName(Mage::getStoreConfig('trans_email/ident_general/name'));
		$mail->setType('html');
	 
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
