<?php

/**
 * Data migration script for System Settings
 */

/**
 * The system settins table is an essential table for the system, and the data
 * ...defined in this migration script is important for the correct functioning
 * ...of the system.
 *
 * Failure to run this script post system installation may result in unexpected
 * ...results and possibly failure of the application.
 *
 * Usage:
 * ...Typical usage is from the command line, using the yiic wrapper:
 * ...
 * ...   cd protected
 * ...   ./yiic migrate up
 * ...eg.
 * ...   ./yiic migrate down
 * ...
 * ...The 'migrate up' command installs the data into the system_settings table
 * ...The 'migrate down' command clears the data from the system_settings table
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

/**
 *
 *
 * @param <none> <none>
 *
 * @return array action specifiers
 * @access public
 */
class m140801_152433_insert_system_settings extends CDbMigration
{

    /**
      * Migrate up - used for installation
      *
      * @param <none> <none>
      *
      * @return <none> <none>
      * @access public
     */
	public function up()
	{
	    $this->insert('tbl_system_settings', array(
	                       'attribute' => 'restaurant_certificate_cost',
	                       'value'     => '25.00'
	                 ));

	    $this->insert('tbl_system_settings', array(
            	           'attribute' => 'cities_in_focus',
            	           'value'     => 'Miami, Clearwater, Mulberry'
            	     ));

	}

	/**
	 * Migrate down - used for de-installation and rollback.
	 *
	 * @param <none> <none>
	 *
	 * @return boolean False means the migration will not be applied.
	 * @access public
	 */
	public function down()
	{

	    $this->truncateTable('tbl_system_settings');
        return true;
	}

}