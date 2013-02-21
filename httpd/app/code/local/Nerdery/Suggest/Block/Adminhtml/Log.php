<?php

class Nerdery_Suggest_Block_Adminhtml_Log extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {

        $this->_controller = 'adminhtml_log';
        $this->_blockGroup = 'suggest';
        $this->_headerText = Mage::helper('suggest')->__('Action Log');
        parent::__construct();


        $this->_removeButton('add');
    }
} 