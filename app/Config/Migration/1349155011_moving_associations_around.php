<?php
class MovingAssociationsAround extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'contractors' => array(
					'image_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'description'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'image_id'),
				),
			),
			'drop_field' => array(
				'users' => array('contractor_id',),
			),
		),
		'down' => array(
			'drop_field' => array(
				'contractors' => array('image_id', 'user_id',),
			),
			'create_field' => array(
				'users' => array(
					'contractor_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
