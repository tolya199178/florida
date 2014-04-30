<?php

/**
 * This is the model class for table "imported_business".
 *
 * The followings are the available columns in table 'imported_business':
 * @property integer $ID1
 * @property integer $ID
 * @property string $source
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $zip
 * @property string $phone
 * @property string $email
 * @property string $website
 * @property string $manta_category
 * @property string $manta_subcategory
 * @property string $manta_industry
 * @property string $old_db_sic
 * @property string $old_db_category
 * @property string $gogo_category
 * @property string $gogo_subcategory
 * @property double $latitude
 * @property double $longitude
 * @property string $gogo_source_url
 * @property string $manta_source_url
 * @property integer $TableID
 * @property string $TP
 * @property string $zip5
 */

 /**
 * ImportedBusiness activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $business = ImportedBusiness::model()
 * ...or
 * ...   $business = new ImportedBusiness;
 * ...or
 * ...   $business = new ImportedBusiness($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class ImportedBusiness extends CActiveRecord
{

    /**
     * Get database table name associated with the model.
     *
     * @param <none> <none>
     *
     * @return string the associated database table name
     * @access public
     */
	public function tableName()
	{
		return 'imported_business';
	}

    /**
     * Set rules for validation of model attributes. Each attribute is listed with its
     * ...associated rules. All attributes listed in the rules set forms a set of 'safe'
     * ...attributes that allow it to be used in massive assignment.
     *
     * @param <none> <none>
     *
     * @return array validation rules for model attributes.
     * @access public
     */
	public function rules()
	{

		return array(
			array('ID1, ID, TableID', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),

			array('source, company_name, address, city, zip, phone, email, website, manta_category, manta_subcategory, manta_industry, old_db_sic, old_db_category, gogo_category, gogo_subcategory, gogo_source_url, manta_source_url, TP, zip5', 'length', 'max'=>255),

		);
	}


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return ImportedBusiness the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
