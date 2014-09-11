<?php
class MageFire_Wall_Model_Observer
{
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
        $getBlackListIp = $blacklistModel->getCollection()
										 ->addFieldToFilter('ip',$ip_address)
										 ->addFieldToFilter('status','1')
										 ->addFieldToFilter('count',array('gteq' => $loginMaxCount))->getData();
 
								 
		if($getBlackListIp)	{							 
			$session = Mage::getSingleton('adminhtml/session');    
			$session->setId(null)
			   ->getCookie()->delete('adminhtml');	
			    Mage::app()->getResponse()->setBody(Mage::helper('adminhtml')->__('Customer move error'));
			$message = 'Email Id Already Exist.';
			Mage::getSingleton('adminhtml/session')->addError($message);	   
			$session = Mage::getSingleton('admin/session');
            $session->addError('Your IP in Blacklist.');
			return;           
		}
	}
}
