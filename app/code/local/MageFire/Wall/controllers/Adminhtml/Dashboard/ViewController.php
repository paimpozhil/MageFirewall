<?php
class MageFire_Wall_Adminhtml_Dashboard_ViewController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->_title($this->__('FIREWALL'))->_title($this->__('Dashboard'))->_title($this->__('View'));
        $this->loadLayout()
            ->_setActiveMenu('wall/dashboard');

        return $this;
	}
	public function indexAction() {
		if ($data = $this->getRequest()->getPost()) {
			try {
				$inchooSwitch = new Mage_Core_Model_Config();
				$inchooSwitch ->saveConfig('mageFireWall/enable', $data['FireWallconfigValue'], 'default', 0);
				if($data['FireWallconfigValue']==1){
					$message = $this->__('Your site is protected now. Please click disabled button to disabled.');
					Mage::getSingleton('adminhtml/session')->addSuccess($message);
				}
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			$this->_redirect('*/*');
		}
		//$this->_addContent($this->getLayout()->createBlock('paymentcapture/adminhtml_paymentcapture'));
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
