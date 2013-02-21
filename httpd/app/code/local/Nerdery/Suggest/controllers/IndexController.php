<?php

/**
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * Retrieve customer session model object
     *
     * @return Nerdery_Suggest_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('suggest/session');
    }

    /**
     * Local method to determine if viewing or voting is allowed 
     * @return null 
     */
    protected function _verifyLoggedIn()
    {
        //redirect customer to login screen with a message before creation
        if(!Mage::getSingleton('customer/session')->isLoggedIn()){

            $this->_getSession()->addError('You must be logged in to perform this action.');
            
            return false;
        }

        return true;
    }

    protected function _verifyCanVote()
    {
        //redirect customer to login screen with a message before creation
        if(!Mage::getModel('suggest/log')->canVote()){

            $this->_getSession()->addError($this->__('Sorry, you may only perform one action per day. Please check back tomorrow!'));

            return false;
        }
        return true;
    }

    /**
     * The index of product suggestion listings
     */
    public function indexAction()
    {
		
        $this->loadLayout();
        $this->_initLayoutMessages('suggest/session');
	    $this->renderLayout();
    }

    /**
     * The creation form for product suggestions
     */
	public function createAction()
    {

        if(!$this->_verifyLoggedIn() || !$this->_verifyCanVote()){
            $this->_redirect('suggest/index/index');
            return;
        }

        //default if logged in
        $this->loadLayout();
		$this->_initLayoutMessages('suggest/session');
	    $this->renderLayout();
	}

    /**
     * The form post action interface for product suggestions
     */
	public function createPostAction()
    {

        if(!$this->_verifyLoggedIn() || !$this->_verifyCanVote()){
            $this->_redirect('suggest/index/index');
            return;
        }

        $session = $this->_getSession();

        $params = $this->getRequest()->getParams();

        //input validation
        $errors = array();
        $alnum = new Zend_Validate_Alnum( array( 'allowWhiteSpace'=>true ) );
        $strlen = new Zend_Validate_StringLength( array( 'min'=>1 ) );

        if(!$alnum->isValid($params['product_name']) ||
           !$strlen->isValid(trim($params['product_name'])) //trimming str to collapse spaces-only posts
           ){
            $errors[] = $this->__('You may only use letters and numbers in the Product Name field.');
        }

        if(!$alnum->isValid($params['product_description']) ||
           !$strlen->isValid(trim($params['product_name'])) //trimming str to collapse spaces-only posts){
           ) {
            $errors[] = $this->__('You may only use letters and numbers in the Product Description field.');
        }

        //if errors present, adderror and redirect
        if(!empty($errors)){
            $session->addError(join('<br/>',$errors));
            $this->_redirect('suggest/index/create/');
            return;
        }

		try { 
            //begin suggestion entry
			$customer_id = Mage::getSingleton('customer/session')->getCustomerId();
			$suggestion = Mage::getModel('suggest/product');

			$suggestion->setProductName($params['product_name'])
							->setProductDescription($params['product_description'])
							->setVotes(0) // new product
							->setCustomerId($customer_id)
							->save();

            $log = Mage::getModel('suggest/log');

            $log->setAction(Nerdery_Suggest_Model_Log::LOG_ACTION_SUGGEST)
                ->setCustomerId($customer_id)
                ->save();

            $session->addSuccess('Your product was added.');
            
        	$this->_redirectSuccess('suggest/index/index/');
            return;

        } catch (Exception $e) {
            $session->setCustomerFormData($this->getRequest()->getPost())
                ->addException($e, $this->__('Another product with this name exists in our database! Please try again.'));
            $this->_redirectError('suggest/index/create/');
            return;
        }

	}

    /**
     * The public interface for voting; requires being logged in
     */
    public function voteAction()
    {

        if(!$this->_verifyLoggedIn() || !$this->_verifyCanVote()){
            $this->_redirect('suggest/index/index');
            return;
        }

        $session = $this->_getSession();

        try {
            $params = $this->getRequest()->getParams();
            $customer_id = Mage::getSingleton('customer/session')->getCustomerId();
            $suggest = Mage::getModel('suggest/product')->load($params['id']);
            
            //add votes to the loaded suggestion
            $votes = $suggest->getVotes();
            $suggest->setVotes(++$votes)
                    ->save();

            //update the action log `nerdery_suggest_log`
            $log = Mage::getModel('suggest/log');

            $log->setAction(Nerdery_Suggest_Model_Log::LOG_ACTION_VOTE)
                ->setCustomerId($customer_id)
                ->save();

            $session->addSuccess('You have successfully voted! You may vote again tomorrow.');

        } catch (Exception $e) {
            $session->addException($e, $this->__('An error occurred while registering your vote.'));
        }

        $this->_redirect('suggest/index/index/');
    }
}