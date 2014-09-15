<?php

class MageFire_Wall_Block_Adminhtml_Whitelist_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('whitelist_form', array('legend'=>Mage::helper('wall')->__('Whitelist information')));
     
      $fieldset->addField('ip', 'text', array(
          'label'     => Mage::helper('wall')->__('IP Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ip',
      ));

      $fieldset->addField('text', 'editor', array(
          'label'     => Mage::helper('wall')->__('Reason'),
          'required'  => false,
          'name'      => 'text',
          'style'     => 'width:274px; height:200px;',
          'wysiwyg'   => false,
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('wall')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('wall')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('wall')->__('Disabled'),
              ),
          ),
      ));     
     
      if ( Mage::getSingleton('adminhtml/session')->getWhitelistData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWhitelistData());
          Mage::getSingleton('adminhtml/session')->setWhitelistData(null);
      } elseif ( Mage::registry('whitelist_data') ) {
          $form->setValues(Mage::registry('whitelist_data')->getData());
      }
      return parent::_prepareForm();
  }
}
