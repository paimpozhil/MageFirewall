<?php

class MageFirewall_Firewall_Block_Adminhtml_Blacklist_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('blacklist_form', array('legend'=>Mage::helper('firewall')->__('Blacklist information')));
     
      $fieldset->addField('ip', 'text', array(
          'label'     => Mage::helper('firewall')->__('IP Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ip',
      ));

      $fieldset->addField('text', 'editor', array(
          'label'     => Mage::helper('firewall')->__('Text'),
          'required'  => false,
          'name'      => 'text',
          'style'     => 'width:274px; height:200px;',
          'wysiwyg'   => false,
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
     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('wall')->__('Content'),
          'title'     => Mage::helper('wall')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getBlacklistData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBlacklistData());
          Mage::getSingleton('adminhtml/session')->setBlacklistData(null);
      } elseif ( Mage::registry('blacklist_data') ) {
          $form->setValues(Mage::registry('blacklist_data')->getData());
      }
      return parent::_prepareForm();
  }
}
