<?php
/**
 * Grid for Nerdery Product Suggestions Module
 * @author philwinkle@gmail.com
 */
class Nerdery_Suggest_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('productSuggestGrid');
        $this->setDefaultSort('votes');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('suggest/product')->getCollection()
                            ->addFieldToFilter('is_converted','0');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('product_name', array(
            'header'    => Mage::helper('suggest')->__('Product Name'),
        	'width'     => '60px',
            'index'     => 'product_name',
        ));
        $this->addColumn('product_description', array(
            'header'    => Mage::helper('suggest')->__('Product Description'),
        	'width'     => '160px',
            'index'     => 'product_description',
        ));
        $this->addColumn('votes', array(
            'header'    => Mage::helper('suggest')->__('# of Votes'),
        	'width'     => '160px',
            'index'     => 'votes',
            'editable'  => true,
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
        return $this->getUrl('*/*/edit', array('suggest_id' => $row->getId()));
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('suggest_id');
        $this->getMassactionBlock()->setFormFieldName('suggest');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('suggest')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('suggest')->__('Are you sure?')
        ));

        return $this; 
    }
}
