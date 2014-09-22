<?php
class MageFirewall_Firewall_Adminhtml_Dashboard_DiagnosticController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->_title($this->__('FIREWALL'))->_title($this->__('Dashboard'))->_title($this->__('View'));
        $this->loadLayout()
            ->_setActiveMenu('firewall/diagnostic');

        return $this;
	}
	public function indexAction() {		
		$block = $this->getLayout()->createBlock('core/template');
        $block->setTemplate('firewall/diagnostic.phtml');

        $this->_initAction()
            ->_addContent($block)
            ->renderLayout();
	}
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('dashboard/adminhtml_diagnostic_grid')->toHtml()
		);
	}
}
