<?php

/**
 * This is the model class for table "restaurant_import".
 *
 * The followings are the available columns in table 'restaurant_import':
 * @property string $PROGRAMNAME
 * @property string $PROGRAMURL
 * @property string $CATALOGNAME
 * @property string $LASTUPDATED
 * @property string $NAME
 * @property string $KEYWORDS
 * @property string $DESCRIPTION
 * @property string $SKU
 * @property string $MANUFACTURER
 * @property string $MANUFACTURERID
 * @property string $UPC
 * @property string $ISBN
 * @property string $CURRENCY
 * @property string $SALEPRICE
 * @property string $PRICE
 * @property string $RETAILPRICE
 * @property string $FROMPRICE
 * @property string $BUYURL
 * @property string $IMPRESSIONURL
 * @property string $IMAGEURL
 * @property string $ADVERTISERCATEGORY
 * @property string $THIRDPARTYID
 * @property string $THIRDPARTYCATEGORY
 * @property string $AUTHOR
 * @property string $ARTIST
 * @property string $TITLE
 * @property string $PUBLISHER
 * @property string $LABEL
 * @property string $FORMAT
 * @property string $SPECIAL
 * @property string $GIFT
 * @property string $PROMOTIONALTEXT
 * @property string $STARTDATE
 * @property string $ENDDATE
 * @property string $OFFLINE
 * @property string $ONLINE
 * @property string $INSTOCK
 * @property string $CONDITION
 * @property string $WARRANTY
 * @property string $STANDARDSHIPPINGCOST
 */

 /**
 * RestaurantImport activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $business = RestaurantImport::model()
 * ...or
 * ...   $business = new RestaurantImport;
 * ...or
 * ...   $business = new RestaurantImport($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class RestaurantImport extends CActiveRecord
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
		return 'restaurant_import';
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
			array('PROGRAMNAME, PROGRAMURL, CATALOGNAME, NAME, BUYURL, IMPRESSIONURL, IMAGEURL, PROMOTIONALTEXT', 'length', 'max'=>255),
			array('LASTUPDATED, SKU, MANUFACTURER, MANUFACTURERID, UPC, ISBN, SALEPRICE, PRICE, RETAILPRICE, FROMPRICE, THIRDPARTYID, TITLE, FORMAT, SPECIAL, GIFT, STARTDATE, ENDDATE, OFFLINE, ONLINE, STANDARDSHIPPINGCOST', 'length', 'max'=>32),
			array('CURRENCY', 'length', 'max'=>6),
			array('ADVERTISERCATEGORY, THIRDPARTYCATEGORY, AUTHOR, ARTIST, PUBLISHER, LABEL, CONDITION, WARRANTY', 'length', 'max'=>64),
			array('INSTOCK', 'length', 'max'=>8),
			array('KEYWORDS, DESCRIPTION', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('PROGRAMNAME, PROGRAMURL, CATALOGNAME, LASTUPDATED, NAME, KEYWORDS, DESCRIPTION, SKU, MANUFACTURER, MANUFACTURERID, UPC, ISBN, CURRENCY, SALEPRICE, PRICE, RETAILPRICE, FROMPRICE, BUYURL, IMPRESSIONURL, IMAGEURL, ADVERTISERCATEGORY, THIRDPARTYID, THIRDPARTYCATEGORY, AUTHOR, ARTIST, TITLE, PUBLISHER, LABEL, FORMAT, SPECIAL, GIFT, PROMOTIONALTEXT, STARTDATE, ENDDATE, OFFLINE, ONLINE, INSTOCK, CONDITION, WARRANTY, STANDARDSHIPPINGCOST', 'safe', 'on'=>'search'),
		);
	}


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return RestaurantImport the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}