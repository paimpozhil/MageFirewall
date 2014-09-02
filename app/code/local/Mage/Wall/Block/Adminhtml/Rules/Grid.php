<?php     
class Mage_Wall_Block_Adminhtml_Rules_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('rulesGrid');
		$this->setDefaultSort('rules_id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	protected function _prepareCollection()
	{
		$orderId = (int) $this->getRequest()->getParam('id');
		if(empty($orderId)){
			$collection = Mage::getModel('wall/rules')->getCollection();
		}
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn('rules_id', array(
			'header'    => Mage::helper('wall')->__('ID #'),
			'align'     => 'left',
			'index'     => 'rules_id',
        ));
        $this->addColumn('who', array(
			'header'    => Mage::helper('wall')->__('Who'),
			'align'     => 'left',
			'index'     => 'who',
        ));
        $this->addColumn('where', array(
			'header'    => Mage::helper('wall')->__('Where'),
			'align'     => 'left',
			'index'     => 'where',
        ));
        $this->addColumn('what', array(
			'header'    => Mage::helper('wall')->__('What'),
			'align'     => 'left',
			'index'     => 'what',
			'width'     => '200px',			
        ));
        $this->addColumn('why', array(
			'header'    => Mage::helper('wall')->__('Why'),
			'align'     => 'left',
			'index'     => 'why',
        ));
        $this->addColumn('level', array(
			'header'    => Mage::helper('wall')->__('Level'),
			'align'     => 'left',
			'index'     => 'level',
        ));
       $this->addColumn('enabled', array(
			'header'    => Mage::helper('wall')->__('Status'),
			'align'     => 'left',
			'index'     => 'enabled',
        ));
        /* $this->addColumn('comments', array(
			'header'    => Mage::helper('paymentcapture')->__('Status Message'),
			'align'     => 'left',
			'index'     => 'comments',
        ));
        $this->addColumn('action_edit', array(
			'header'   => $this->helper('paymentcapture')->__('Action'),
			'width'    => 80,
			'sortable' => false,
			'filter'   => false,
			'renderer' => new Grossman_Paymentcapture_Block_Adminhtml_Renderer_Action(),
		));
		
        $this->addColumn('action',
array(
          'header' => Mage::helper('paymentcapture')->__(''),
          'width' => '100',
          'type' => 'action',
          'getter' => 'getId',
          'actions' => array(
                 array(
                      'caption' => Mage::helper('paymentcapture')->__('Log'),
                      'url' => array('base'=> 'adminhtml/paymentcapture_view'),
                      'field' => 'id'
                    )),
          'filter' => false,
          'sortable' => false,
          'index' => 'stores',
          'is_system' => true,
));*/
		return parent::_prepareColumns();
	}
	public function getGridUrl()
	{
	  return $this->getUrl('*/*/grid', array('_current'=>true));
	}
}
