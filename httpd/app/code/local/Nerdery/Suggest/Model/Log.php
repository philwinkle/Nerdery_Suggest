<?php

/**
 * This module controls the ability for an end-user to vote by
 * restricting votes to 1-per 24 hours or weekdays (based on 
 * configuration setting.)
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_Model_Log extends Mage_Core_Model_Abstract
{
    //setting some default values for the action column in `nerdery_suggest_log`
    const LOG_ACTION_SUGGEST = 'suggest';
    const LOG_ACTION_VOTE = 'vote';
    const LOG_ACTION_ADMIN_CONVERT = 'admin_convert';
    const LOG_ACTION_ADMIN_EDIT = 'admin_edit';


    protected function _construct()
    {
        $this->_init('suggest/log');
    }

    /**
     * Return array of weekend days for current store
     * @return boolean
     */
    protected function _isWeekendDay()
    {
        $_weekend_days = explode(',',Mage::getStoreConfig('general/locale/weekend',(int)Mage::app()->getStore()->getStoreId()));
        $today = Zend_Date::now();
        return in_array($today->get(Zend_Date::WEEKDAY_DIGIT), $_weekend_days);
    }

    public function isWeekendDay()
    {
        return $this->_isWeekendDay();
    }

    public function isWeekendAllowed()
    {
        return Mage::getStoreConfig('nerdery/suggest/weekend');
    }

    /**
     * Provide an interface flag from the model to the resource model
     * @return boolean canVote from Resource Model
     */
    public function canVote()
    {
        $customer_id = Mage::getSingleton('customer/session')->getCustomerId();

        if(!$this->isWeekendAllowed() && $this->isWeekendDay()){
            return false;
        }
        return $this->_getResource()->canVote($customer_id);
    }

}
