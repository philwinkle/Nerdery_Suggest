<?php

/**
 * @author philwinkle@gmail.com
 */

class IndexControllerTest extends MageTest_PHPUnit_Framework_ControllerTestCase
{
	public function createPostAction(){
		//on hold
		$this->request->setMethod('POST')
		         ->setPost(array(
					'product_name'=>'Testing Product',
					'product_description'=>'Another Description About My Product'
		           ));
		$this->dispatch('/recommendation/index/createPost');
	}

	public function test_addVotesAction(){
		$recommendation = Mage::getModel('nerdery/recommendations')->load(2);
		$this->assertEquals(2,$recommendation->getId());
		$_votescount = (int) $recommendation->getVotes();

		$this->request->setMethod('POST')
		         ->setPost(array(
					'id'=>2
		           ));
		$this->dispatch('/recommendations/index/addVotes');
		$this->assertResponseCode('200', '/recommendations/index/addVotes/ has not responded as expected');

		$_recommendation = Mage::getSingleton('nerdery/recommendations')->load(2);

		$this->assertNotEquals($_votescount,(int)$_recommendation->getVotes());
	}

	public function test_showAllRecommendationsAction(){

		$this->request->setMethod('POST')
		         ->setPost(array(
					'id'=>2
		           ));
		$this->dispatch('/recommendations/index/showAllRecommendations');
		$this->assertResponseCode('200', '/recommendations/index/showAllRecommendations/ has not responded as expected');
		$this->expectOutputRegex('/.*My Cool Product.*/');
	}

	public function test_createPostAction(){

		$this->request->setMethod('POST')
		         ->setPost(array(
					'product_name'=>'Anything You Want',
					'product_description'=>'Another Great Thing'
		           ));
		$this->dispatch('/recommendations/index/createPost');
		$this->assertResponseCode('200', '/recommendations/index/createPost/ has not responded as expected');

		$recommendation = Mage::getModel('nerdery/recommendations')->getCollection()->getLastItem();
		$this->assertGreaterThan(0,count($recommendation));

		$this->assertInstanceOf('Nerdery_ProductRecommendation_Model_Recommendations',$recommendation);
		$this->assertEquals('Anything You Want',$recommendation->getProductName());
		$this->assertEquals('Another Great Thing',$recommendation->getProductDescription());
	}
}