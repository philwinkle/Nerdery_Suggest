<?php

/**
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_Model_Resource_Log extends Mage_Core_Model_Resource_Db_Abstract{
    
    protected function _construct()
    {
        $this->_init('suggest/log', 'entity_id');
    }

    /**
     * Provide an interface flag for voting rights (based on date of last action)
     * @param  boolean $customer_id 
     * @return boolean logical
     */
    public function canVote($customer_id)
    {

        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('suggest/log'), 'entity_id')
            ->where('customer_id = ?', (int)$customer_id)
            ->where("DATE_FORMAT( created_at,  '%m-%d' ) = DATE_FORMAT( NOW( ) ,  '%m-%d' )");

        if($this->_getReadAdapter()->fetchOne($select)){
            return false;
        }

        return true;
    }

}