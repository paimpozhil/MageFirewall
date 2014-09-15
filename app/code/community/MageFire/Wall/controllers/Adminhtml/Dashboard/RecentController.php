<?php
class MageFire_Wall_Adminhtml_Dashboard_RecentController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->_title($this->__('FIREWALL'))->_title($this->__('Dashboard'))->_title($this->__('View'));
        $this->loadLayout()
            ->_setActiveMenu('wall/recentedittedfile');

        return $this;
	}
	public function indexAction() {		
		$block = $this->getLayout()->createBlock('core/template');
        $block->setTemplate('firewall/recentfile.phtml');

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
