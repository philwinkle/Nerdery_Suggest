<?php


class Nerdery_Suggest_Block_Adminhtml_Log_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('logGrid');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('suggest/log')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('customer_id', array(
            'header'    => Mage::helper('suggest')->__('Customer ID'),
        	'width'     => '60px',
            'index'     => 'customer_id',
        ));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('suggest')->__('Created At'),
            'type'      => 'datetime', 
            'width'     => '160px',
            'gmtoffset' => true,
            'default'   => ' ---- ',
            'index'     => 'created_at',
        ));
        $this->addColumn('action', array(
            'header'    => Mage::helper('suggest')->__('Action'),
        	'width'     => '160px',
            'index'     => 'action',
        ));


        return parent::_prepareColumns();
    }


    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('suggest_id');
        $this->getMassactionBlock()->setFormFieldName('suggest');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('suggest')->__('Delete'),
             'url'      => $this->getUrl('*/*/massLogDelete'),
             'confirm'  => Mage::helper('suggest')->__('Are you sure?')
        ));

        return $this; 
    }
}
