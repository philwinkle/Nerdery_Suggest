<?php

/**
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_Block_Product_List extends Mage_Core_Block_Template
{

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('suggest')->__('Product Suggestions'));
        return parent::_prepareLayout();
    }

    protected function _getSuggestionsCollection()
    {
        return Mage::getModel('suggest/product')->getCollection()
                            ->addFieldToFilter('is_converted','0')
                            ->setOrder('votes','desc');
    }

    /**
     * Interface to the model value of canVote
     * @return boolean Nerdery_Suggest_Model_Log
     */
    protected function _canVote()
    {
        return Mage::getModel('suggest/log')->canVote();
    }

    /**
     * Check if Voting is Disabled due to Weekend Configuration Setting
     * @return boolean true
     */
    public function isVotingDisabled()
    {
        $_log = Mage::getModel('suggest/log');
        if(!$_log->isWeekendAllowed() && $_log->isWeekendDay()){
                return true;
        }
        return false;
    }

    public function isWeekendDay()
    {
        return Mage::getModel('suggest/log')->isWeekendDay();
    }

    public function getSuggestions()
    {
        return $this->_getSuggestionsCollection();
    }

    public function getSuggestCreateUrl()
    {
        return $this->getUrl('suggest/index/create/');
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('suggest/index/createPost/');
    }

    public function getSuccessUrl()
    {
        return $this->getUrl('suggest/');
    }

    public function getErrorUrl()
    {
        return $this->getUrl('suggest/index/create/');
    }

    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('suggest/');
    }

    public function getLoginUrl()
    {
        return $this->getUrl('customer/account/login/');
    }

    public function getVoteUrl($_id=0){
        $_id = (int) $_id;
        return $this->getUrl('suggest/index/vote',array('id' => $_id));
    }

    public function isLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

    public function canVote()
    {
        return $this->_canVote(); 
    }

    /**
     * From Mage_Customer_Block_Form_Register
     * @todo replace with a more proper method
     */
    public function getCustomerFormData()
    {
        $data = $this->getData('form_data');
        if (is_null($data)) {
            $formData = Mage::getSingleton('suggest/session')->getCustomerFormData(true);
            $data = new Varien_Object();
            if ($formData) {
                $data->addData($formData);
                $data->setCustomerData(1);
            }

            $this->setData('form_data', $data);
        }
        return $data;
    }

}