<?php
class MageFire_Wall_Model_Observer
{
	/* 
	 * store ipaddress in blacklist if admin entered wrong password
	 * */
    public function login_validation($observer = null)
    {
        $event = $observer->getEvent(); 
        $controllerAction = $event->getControllerAction();
        $blacklistModel = Mage::getModel('wall/blacklist');		
        $wallHelper = Mage::helper('wall');
		$ip_address = $wallHelper->getClientIp();
        $model1 = $blacklistModel->getCollection()->addFieldToFilter('ip',$ip_address)->getData();
        if($model1){
	      foreach($model1 as $getcount){		
				$count=$getcount['count']+1;
				$id=$getcount['blacklist_id'];
				$blacklistModel->setId($id)
								->setCount($count)
								->setUpdatedTime(time())
								->save();
           }
	    }
		else{
		   $data = array('ip'=>$ip_address,'priority'=>'Normal','count'=>1,'is_delete'=>0,'status'=>1,'text'=>'admin login','created_time'=>time());
		   $model = $blacklistModel->setData($data)->save();
	    }		
   }
   public function checkBlacklist($observer = null)
    {	
		$blacklistModel = Mage::getModel('wall/blacklist');			
		$wallHelper = Mage::helper('wall');	
		$loginMaxCount = (int) $wallHelper->getOptionsData('login_lttempts');
		$ip_address = $wallHelper->getClientIp();
		$checkipinblacklist = $blacklistModel->getCollection()
											->addFieldToFilter('count',array('lt' => $loginMaxCount))
											->addFieldToFilter('ip',$ip_address)->getData();
        if($checkipinblacklist){
			$blacklistModel->setId($checkipinblacklist[0]['blacklist_id'])
					->delete();	    
	    }
        $getBlackListIp = $blacklistModel->getCollection()
										 ->addFieldToFilter('ip',$ip_address)
										 ->addFieldToFilter('status','1')
										 ->addFieldToFilter('count',array('gteq' => $loginMaxCount))->getData();
						 
		if($getBlackListIp)	{							 
			$session = Mage::getSingleton('adminhtml/session');    
			$adminSession = Mage::getSingleton('admin/session');
			$adminSession->unsetAll();
			$adminSession->getCookie()->delete($adminSession->getSessionName());         
		}
	}
}
