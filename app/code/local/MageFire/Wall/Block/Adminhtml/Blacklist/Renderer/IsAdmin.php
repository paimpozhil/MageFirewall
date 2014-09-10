<?php
class MageFire_Wall_Block_Adminhtml_Blacklist_Renderer_IsAdmin extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
    {	
		$datas = $row->getData();
		echo ($datas['admin_login']==1) ? 'Admin login try' : '' ;
    }
}
?>
