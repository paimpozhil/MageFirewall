<?php

class MageFire_Wall_Block_Adminhtml_Rules_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('wall_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('wall')->__('Rules Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('wall')->__('Rules Information'),
          'title'     => Mage::helper('wall')->__('Rules Information'),
          'content'   => $this->getLayout()->createBlock('wall/adminhtml_wall_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
