<?php     
class MageFire_Wall_Block_Adminhtml_Whitelist_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('whitelistGrid');
		$this->setDefaultSort('whitelist_id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	protected function _prepareCollection()
	{
		$orderId = (int) $this->getRequest()->getParam('id');
		if(empty($orderId)){
			$collection = Mage::getModel('wall/whitelist')->getCollection();
		}
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn('whitelist_id', array(
			'header'    => Mage::helper('wall')->__('ID #'),
			'align'     => 'left',
			'index'     => 'whitelist_id',
        ));
        $this->addColumn('ip', array(
			'header'    => Mage::helper('wall')->__('IP Address'),
			'align'     => 'left',
			'index'     => 'ip',
        ));
        $this->addColumn('text', array(
			'header'    => Mage::helper('wall')->__('Text'),
			'align'     => 'left',
			'index'     => 'text',
        ));
        $this->addColumn('created_time', array(
			'header'    => Mage::helper('wall')->__('Created Time'),
			'align'     => 'left',
			'index'     => 'created_time',
        ));
		return parent::_prepareColumns();
	}
	
	public function getGridUrl()
	{
	  return $this->getUrl('*/*/grid', array('_current'=>true));
	}

	  public function getRowUrl($row)
	  { 
		  return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	  }
}
