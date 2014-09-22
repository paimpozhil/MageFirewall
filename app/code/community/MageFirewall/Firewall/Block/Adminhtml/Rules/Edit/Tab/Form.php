<?php

class MageFirewall_Firewall_Block_Adminhtml_Rules_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('rules_form', array('legend'=>Mage::helper('firewall')->__('Rules information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('firewall')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('firewall')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('firewall')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('firewall')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('firewall')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('firewall')->__('Content'),
          'title'     => Mage::helper('firewall')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getRulesData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getRulesData());
          Mage::getSingleton('adminhtml/session')->setRulesData(null);
      } elseif ( Mage::registry('rules_data') ) {
          $form->setValues(Mage::registry('rules_data')->getData());
      }
      return parent::_prepareForm();
  }
}
