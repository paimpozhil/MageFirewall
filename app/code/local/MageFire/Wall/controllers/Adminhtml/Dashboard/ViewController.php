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
				$optionsAll = Mage::getModel('wall/options');
				foreach($data['fireWall_options'] as $datas){
					if(isset($datas['value']))
					$optionsAll->setData($datas);
					$optionsAll->save();
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
