<?php

class MageFire_Wall_Block_Adminhtml_Blacklist_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('wall_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('wall')->__('Blacklist Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('wall')->__('Blacklist Information'),
          'title'     => Mage::helper('wall')->__('Blacklist Information'),
          'content'   => $this->getLayout()->createBlock('wall/adminhtml_blacklist_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
