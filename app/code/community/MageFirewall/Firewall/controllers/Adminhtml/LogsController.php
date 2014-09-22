<?php
class MageFirewall_Firewall_Adminhtml_LogsController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('firewall/logs')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Logs'), Mage::helper('adminhtml')->__('Logs'));
		return $this;
	}
	public function indexAction() {
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('firewall/adminhtml_logs'));
		$this->renderLayout();
	}
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('firewall/adminhtml_logs_grid')->toHtml()
		);
	}
}
