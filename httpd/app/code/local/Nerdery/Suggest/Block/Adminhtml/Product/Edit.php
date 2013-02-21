<?php

class Nerdery_Suggest_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        
        $params = $this->getRequest()->getParams();
        if(isset($params['suggest_id'])){
            $_id = $params['suggest_id'];
        }
        $this->_objectId = 'suggest_id';
        $this->_blockGroup = 'suggest';
        $this->_controller = 'adminhtml_product';

        $this->_removeButton('reset');

        //add the button to enable convert from the suggestion detail page
        if(isset($_id)){
            $this->_addButton('convert', array(
                'label'     => Mage::helper('suggest')->__('Convert to Product'),
                'onclick'   => "confirmSetLocation('" . Mage::helper('suggest')->__('Are you sure?') .  "','" . $this->getUrl('*/*/convert',array('suggest_id'=>$_id)) . "')",
                'class'     => ''
            ));       
        }


    }

    public function getHeaderText()
    {
            return Mage::helper('suggest')->__('Edit Product Suggestion');
    }
}