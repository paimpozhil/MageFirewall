<?php
class MageFirewall_Firewall_Adminhtml_Dashboard_ViewController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->_title($this->__('FIREWALL'))->_title($this->__('Dashboard'))->_title($this->__('View'));
        $this->loadLayout()
            ->_setActiveMenu('firewall/dashboard');

        return $this;
	}
	public function indexAction() {
		$wallHelper = Mage::helper('firewall');		
		if ($data = $this->getRequest()->getPost()) {
			try {
				$optionsAll = Mage::getModel('firewall/options');
				foreach($data['fireWall_options'] as $datas){
					if(isset($datas['value']))
					$optionsAll->setData($datas);
					$optionsAll->save();
				}
				if($data['fireWall_options'][6]['value']==1){
					$ip_address = $wallHelper->getClientIp();
					$whitelist = Mage::getModel('firewall/whitelist');
					$getWhiteList = Mage::getModel('firewall/whitelist')->getCollection()->addFieldToFilter('ip',$ip_address)->getData();
					if(count($getWhiteList)>=1){						
					} else {
						$whitelist->setData(array('ip'=>$ip_address,'is_delete'=>0,'status'=>1,'created_time'=>time()))
								  ->save();
					}
				}			
								
				Mage::getSingleton('adminhtml/session')->addSuccess('Configuration saved succesfully.');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			$this->_redirect('*/*');
		}
		$block = $this->getLayout()->createBlock('core/template');
        $block->setTemplate('firewall/dashboard.phtml');

        $this->_initAction()
            ->_addContent($block)
            ->renderLayout();
	}
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('dashboard/adminhtml_dashboard_grid')->toHtml()
		);
	}
}
