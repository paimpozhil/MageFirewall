<?php     
class MageFire_Wall_Block_Adminhtml_Logs_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('logsGrid');
		$this->setDefaultSort('log_id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	protected function _prepareCollection()
	{
		$orderId = (int) $this->getRequest()->getParam('id');
		if(empty($orderId)){
			$collection = Mage::getModel('wall/logs')->getCollection();
		}
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn('log_id', array(
			'header'    => Mage::helper('wall')->__('ID #'),
			'align'     => 'left',
			'index'     => 'log_id',
        ));
        $this->addColumn('ruleid', array(
			'header'    => Mage::helper('wall')->__('Rule ID'),
			'align'     => 'left',
			'index'     => 'ruleid',
        ));
        $this->addColumn('summary', array(
			'header'    => Mage::helper('wall')->__('Summary'),
			'align'     => 'left',
			'index'     => 'summary',
        ));
        $this->addColumn('ip', array(
			'header'    => Mage::helper('wall')->__('IP Address'),
			'align'     => 'left',
			'index'     => 'ip'
        ));
        $this->addColumn('level', array(
			'header'    => Mage::helper('wall')->__('Level'),
			'align'     => 'left',
			'index'     => 'level'
        ));
        $this->addColumn('incidentid', array(
			'header'    => Mage::helper('wall')->__('Incident Id'),
			'align'     => 'left',
			'index'     => 'incidentid',
        ));
        $this->addColumn('created_time', array(
			'header'    => Mage::helper('wall')->__('Date'),
			'align'     => 'left',
			'index'     => 'created_time',
        ));
		return parent::_prepareColumns();
	}
	public function getGridUrl()
	{
	  return $this->getUrl('*/*/grid', array('_current'=>true));
	}
}
