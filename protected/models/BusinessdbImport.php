<?php

/**
 * This is the model class for table "businessdb_import".
 *
 * The followings are the available columns in table 'businessdb_import':
 * @property string $﻿ID
 * @property string $source
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $zip
 * @property string $phone
 * @property string $email
 * @property string $website
 * @property string $latitude
 * @property string $longitude
 * @property string $TableID
 * @property string $TP
 * @property string $zip5
 * @property string $manta_Category
 * @property string $manta_SubCategory
 * @property string $manta_industry
 * @property string $old_db_sic
 * @property string $old_db_category
 * @property string $gogo_category
 * @property string $gogo_Subcategory
 * @property string $gogo_Source_URL
 * @property string $manta_source_url
 */

 /**
 * BusinessdbImport activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = BusinessdbImport::model()
 * ...or
 * ...   $model = new BusinessdbImport;
 * ...or
 * ...   $model = new BusinessdbImport($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class BusinessdbImport extends CActiveRecord
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
		return 'businessdb_import';
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
			array('﻿ID, latitude, longitude, TableID', 'length', 'max'=>16),
			array('source, zip5', 'length', 'max'=>8),
			array('company_name, gogo_category, gogo_Subcategory', 'length', 'max'=>64),
			array('address, city, email, website, manta_Category, manta_SubCategory, manta_industry, old_db_sic, old_db_category, manta_source_url', 'length', 'max'=>255),
			array('zip, phone, TP', 'length', 'max'=>32),
			array('gogo_Source_URL', 'length', 'max'=>132),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('﻿ID, source, company_name, address, city, zip, phone, email, website, latitude, longitude, TableID, TP, zip5, manta_Category, manta_SubCategory, manta_industry, old_db_sic, old_db_category, gogo_category, gogo_Subcategory, gogo_Source_URL, manta_source_url', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return BusinessdbImport the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
