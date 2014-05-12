<?php
/**
 * Command Class for the migration script m140512_061930_create_initial_city_record
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * m140512_061930_create_initial_city_record is a yiic migration script that
 * ...create an initial Control record for the {{city}} table.
 * ...
 * ...The control record is not intended to use as a valid business record
 * ...and is used as a placeholder record for other table records that must be
 * ...created with a valid city record for validation purposes.
 * ...
 * ...The usage is often restricted to data imports or precreation of unclaimed
 * ...records, where it is expected that a vald data owner will claim the record
 * ...and populate the final record, or make a correction to the imported record.
 *
 * @package Commands
 * @version 1.0
 */

class m140512_061930_create_initial_city_record extends CDbMigration
{

    /**
     * Migrate up function.
     * This function will run when an upward migration is specified.
     * ...
     * ...Upward migration is the default action and is invoked if no
     * ...action is specified during the migration.
     *
     * @param <none> <none>
     *
     * @return array array validation rules for model attribute.
     * @access public
     */
	public function up()
	{
	    $this->insert('{{city}}', array(
	        'city_id'              => '1',
	        'city_name'            => 'Florida Control City',
	        'city_alternate_name'  => 'Florida Control City - not used as valid data city',
	        'state_id'             => '1',
	        'is_featured'          => 'N',
	        'time_zone'            => null,
	        'isactive'             => 'N',
	        'description'          => 'Florida Control City - not used as valid data city',
	        'more_information'     => '',
	        'image'                => null,
	        'latitude'             => null,
	        'longitude'            => null
	    ));
	}

	/**
	 * Migrate up function.
	 * This function will run when an downward migration is specified.
	 * ...
	 * @param <none> <none>
	 *
	 * @return result boolean sucess flag for migration
	 * @access public
	 */
	public function down()
	{
		echo 'm140512_061930_create_initial_city_record does not support migration down.'."\n";
		return false;
	}

}