<?php
class AddingZipsMaps extends CakeMigration {

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
			'create_table' => array(
				'contacts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'id'),
					'contractor_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'user_id'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'after' => 'contractor_id'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),
				'zips' => array(
					'zip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'lat' => array('type' => 'float', 'null' => false, 'default' => NULL, 'key' => 'index', 'after' => 'zip'),
					'lon' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'lat'),
					'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'lon'),
					'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'city'),
					'county' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'state'),
					'is_primary' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'after' => 'county'),
					'population' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'is_primary'),
					'cityaliasname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'population'),
					'areacode' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'cityaliasname'),
					'indexes' => array(
						'lat' => array('column' => array('lat', 'lon'), 'unique' => 0),
						'zip' => array('column' => array('zip', 'lat', 'lon'), 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'),
				),
			),
			'create_field' => array(
				'contractors' => array(
					'company_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'last_name'),
					'street' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'phone_number'),
					'street_2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'street'),
					'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'street_2'),
					'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'city'),
					'zip' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'after' => 'state'),
					'lat' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '10,6', 'after' => 'zip'),
					'lon' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '10,6', 'after' => 'lat'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'contacts', 'zips'
			),
			'drop_field' => array(
				'contractors' => array('company_name', 'street', 'street_2', 'city', 'state', 'zip', 'lat', 'lon',),
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
