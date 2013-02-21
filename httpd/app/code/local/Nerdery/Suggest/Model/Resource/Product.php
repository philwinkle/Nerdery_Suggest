<?php

/**
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_Model_Resource_Product extends Mage_Core_Model_Resource_Db_Abstract{
	
    protected function _construct()
    {
        $this->_init('suggest/product', 'entity_id');
    }

}