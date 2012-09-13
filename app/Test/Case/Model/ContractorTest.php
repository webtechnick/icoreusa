<?php
App::uses('Contractor', 'Model');

/**
 * Contractor Test Case
 *
 */
class ContractorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contractor',
		'app.upload',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contractor = ClassRegistry::init('Contractor');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contractor);

		parent::tearDown();
	}

}
