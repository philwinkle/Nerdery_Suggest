<?php
/**
 * Admin Controller for the Nerdery Product Suggestion Module
 * @author philwinkle@gmail.com
 */

class Nerdery_Suggest_AdminController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout();
        $this->_setActiveMenu('nerdery_modules/suggestion_module/suggestion_management');
        return $this;
    }	
        
    public function indexAction()
    {
        $this->manageAction();
    }

    public function manageAction()
    {

        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('suggest/adminhtml_product'))
            ->renderLayout();
    }   
    
    public function logAction()
    {
        
          $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('suggest/adminhtml_log'))
            ->renderLayout();
        
    }   

    public function newAction()
    {
        $this->editAction();
    }

    /**
     * Convert the Product Suggestion into a real product
     * @todo handle more than simple products, new attribute sets
     */
    
    public function convertAction()
    {

        $id     = $this->getRequest()->getParam('suggest_id');
        $model  = Mage::getModel('suggest/product')->load($id);

        //create the product
        $api = new Mage_Catalog_Model_Product_Api();
        $attribute_api = new Mage_Catalog_Model_Product_Attribute_Set_Api();

        //find and set the default attribute set id
        //set to 0 by default
        $default_set_id = 0;
        foreach($attribute_api->items() as $_set){
        if($_set['name']=='Default'){
            $default_set_id = $_set['set_id'];
            break;
          } 
        }

        $productData = array(
                'website_ids'       => array(1), 
                'categories'        => array(0),
                'status'            => 1,
                'name'              => utf8_encode($model->getProductName()),
                'description'       => utf8_encode($model->getProductDescription()),
                'short_description' => utf8_encode($model->getProductDescription()),
                'price'             => 1.99,
                'weight'            => 1.00,
                'tax_class_id'      => 0,
                'page_layout'       =>'two_columns_left'
        );

        try { 
            
            //convert suggestion to product
            $new_product_id = $api->create('simple',$default_set_id,uniqid(),$productData);

            //set product as converted in the suggestion table
            $model->setIsConverted(true)->setConvertedAt(date('Y-m-d h:i:s'))->save();

            //register success and redirect
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('suggest')->__('Your product was successfully converted. Please fill in the rest of the information below.'));
            $this->_redirect('adminhtml/catalog_product/edit', array('id' => $new_product_id));

        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('suggest_id' => $id));
            return;
        }
    }


    public function editAction()
    {
        $id     = $this->getRequest()->getParam('suggest_id');
        $model  = Mage::getModel('suggest/product')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('suggest_data', $model);

            $this->loadLayout();

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('suggest/adminhtml_product_edit'));
            
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('suggest')->__('Item does not exist'));
            $this->_redirect('suggest/admin/manage');
        }
    }

    public function saveAction()
    {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('suggest/product');
        if ($data = $this->getRequest()->getPost()) {
            $model->setData($data)->setId($id);
            try {
                $model->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('suggest')->__('Product Suggestion has been successfully updated.'));    
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                $this->_redirect('suggest/admin/manage');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('suggest')->__('Unable to find item to save'));
        $this->_redirect('suggest/admin/manage');
    }

    /**
     * Delete Product Suggestions
     * @return null 
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('suggest');
        if(!is_array($ids)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('suggest')->__('Please select product(s)'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getModel('suggest/product')->load($id);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('suggest')->__(
                        'Total of %d record(s) were successfully deleted', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('suggest/admin/manage');
    }
    
    /**
     * Delete Log Entries
     * @return null 
     */
    public function massLogDeleteAction()
    {
        $ids = $this->getRequest()->getParam('suggest');
        if(!is_array($ids)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('suggest')->__('Please select log entries'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getModel('suggest/log')->load($id);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('suggest')->__(
                        'Total of %d record(s) were successfully deleted', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('suggest/admin/log');
    }
    
    
} 
