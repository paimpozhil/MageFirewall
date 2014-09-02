<?php

class Mage_Wall_Block_Adminhtml_Blacklist_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'wall';
        $this->_controller = 'adminhtml_blacklist';
        
        $this->_updateButton('save', 'label', Mage::helper('wall')->__('Save blacklist'));
        $this->_updateButton('delete', 'label', Mage::helper('wall')->__('Delete blacklist'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('wall_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'wall_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'wall_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('rules_data') && Mage::registry('blacklist_data')->getId() ) {
            return Mage::helper('wall')->__("Edit blacklist '%s'", $this->htmlEscape(Mage::registry('blacklist_data')->getTitle()));
        } else {
            return Mage::helper('wall')->__('Add blacklist');
        }
    }
}
