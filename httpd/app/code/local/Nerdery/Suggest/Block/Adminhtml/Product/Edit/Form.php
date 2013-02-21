<?php


class Nerdery_Suggest_Block_Adminhtml_Product_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('suggest_id'))),
            'method' => 'post'));

        $form->setUseContainer(true);
        $this->setForm($form);
        $hlp = Mage::helper('suggest');

        $fldInfo = $form->addFieldset('suggest_info', array('legend'=> $hlp->__('Product Suggestions')));
        
        $fldInfo->addField('product_name', 'text', array(
            'label'     => $hlp->__('Product Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'product_name',
        ));
        $fldInfo->addField('product_description', 'text', array(
            'label'     => $hlp->__('Product Description'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'product_description',
        ));
        $fldInfo->addField('votes', 'text', array(
            'label'     => $hlp->__('# of Votes'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'votes',
        ));


        if ( Mage::registry('suggest_data') ) {
            $form->setValues(Mage::registry('suggest_data')->getData());
        }
        
        return parent::_prepareForm();
    }
}