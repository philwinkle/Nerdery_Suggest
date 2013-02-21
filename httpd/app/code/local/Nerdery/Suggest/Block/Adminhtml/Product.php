<?php

class Nerdery_Suggest_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'suggest';
        $this->_headerText = Mage::helper('suggest')->__('Product Suggestion Queue');
        parent::__construct();
    }
} 