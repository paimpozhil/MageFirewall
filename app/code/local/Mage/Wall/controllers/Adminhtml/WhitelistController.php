<?php
class Mage_Wall_Adminhtml_WhitelistController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('sales/sales')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Tracking List'), Mage::helper('adminhtml')->__('Tracking List'));
		return $this;
	}
	public function indexAction() {
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('wall/adminhtml_whitelist'));
		$this->renderLayout();
	}
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('wall/adminhtml_wall_grid')->toHtml()
		);
	}
}
