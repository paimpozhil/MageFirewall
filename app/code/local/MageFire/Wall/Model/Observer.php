<?php
class MageFire_Wall_Model_Observer
{
    public function login_validation($observer = null)
    {
        $event = $observer->getEvent(); 
        $controllerAction = $event->getControllerAction();
        echo "Login Failed";
        $model = Mage::getModel('wall/blacklist');		
        $wallHelper = Mage::helper('wall');
		$ip_address = $wallHelper->getClientIp();
        $model1 = $model->getCollection()->addFieldToFilter('ip',$ip_address)->getData();
        if($model1){
	      foreach($model1 as $getcount){		
				$count=$getcount['count']+1;
				$id=$getcount['blacklist_id'];
				$model =  $model->setId($id)
								->setCount($count)
								->setUpdatedTime(time())
								->save();
           }
	    }
		else{
		   $data = array('ip'=>$ip_address,'priority'=>'Normal','count'=>1,'is_delete'=>0,'status'=>1,'admin_login'=>'1','created_time'=>time());
		   $model = $model->setData($data)->save();
	    }		
   }
}
