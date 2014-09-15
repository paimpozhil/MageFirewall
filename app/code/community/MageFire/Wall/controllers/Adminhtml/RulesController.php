<?php
class MageFire_Wall_Adminhtml_RulesController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('wall/rules')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Rules List'), Mage::helper('adminhtml')->__('Rules List'));
		return $this;
	}
	public function indexAction() {
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('wall/adminhtml_rules'));
		$this->renderLayout();
	}
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('wall/adminhtml_rules_grid')->toHtml()
		);
	}
}
