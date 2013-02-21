<?php

/**
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_Model_Session extends Mage_Core_Model_Session_Abstract
{
    public function __construct()
    {
        $this->init('suggest');
    }

}