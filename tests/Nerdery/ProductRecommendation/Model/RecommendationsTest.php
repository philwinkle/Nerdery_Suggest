<?php

/**
 * @author philwinkle@gmail.com
 */

class RecommendationsTest extends MageTest_PHPUnit_Framework_TestCase
{
	public function test_model(){
		$model = Mage::getModel('nerdery/recommendations');
		$this->assertInstanceOf('Nerdery_ProductRecommendation_Model_Recommendations',$model);
	}
	
	public function test_modelResourceCollection(){
		$collection = Mage::getModel('nerdery/recommendations')->getCollection();
		$this->assertGreaterThan(1,count($collection));
	}
}