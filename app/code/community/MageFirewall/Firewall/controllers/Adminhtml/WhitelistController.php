<?php
class MageFirewall_Firewall_Adminhtml_WhitelistController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('firewall/whitelist')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Whitelist'), Mage::helper('adminhtml')->__('Whitelist'));
		return $this;
	}
	public function indexAction() {
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('firewall/adminhtml_whitelist'));
		$this->renderLayout();
	}
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('firewall/adminhtml_whitelist_grid')->toHtml()
		);
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('firewall/whitelist')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('whitelist_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('firewall/whitelist');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Whitelist Manager'), Mage::helper('adminhtml')->__('Whitelist Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('firewall/adminhtml_whitelist_edit'))
				->_addLeft($this->getLayout()->createBlock('firewall/adminhtml_whitelist_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('firewall')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			  			
	  			
			$model = Mage::getModel('firewall/whitelist');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('firewall')->__('Whitelist was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('firewall')->__('Unable to find Whitelist to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('firewall/whitelist');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Whitelist was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
}
