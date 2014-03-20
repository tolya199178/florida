<?php

/**
 * This is the model class for table "hotel_import".
 *
 * The followings are the available columns in table 'hotel_import':
 * @property string $hotelid_ppn
 * @property string $hotelid_a
 * @property string $hotelid_b
 * @property string $hotelid_t
 * @property string $hotel_name
 * @property string $hotel_address
 * @property string $city
 * @property string $cityid_ppn
 * @property string $state
 * @property string $state_code
 * @property string $country
 * @property string $country_code
 * @property string $latitude
 * @property string $longitude
 * @property string $area_id
 * @property string $postal_code
 * @property string $star_rating
 * @property string $low_rate
 * @property string $currency_code
 * @property string $review_rating
 * @property string $review_count
 * @property string $rank_score_ppn
 * @property string $chain_id_ppn
 * @property string $thumbnail
 * @property string $has_photos
 * @property string $room_count
 * @property string $check_in
 * @property string $check_out
 * @property string $property_description
 * @property string $amenity_codes
 * @property string $active
 * @property string $mod_date_time
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $hotel_import = HotelImport::model()
 * ...or
 * ...   $hotel_import = new HotelImport;
 * ...or
 * ...   $hotel_import = new HotelImport($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class HotelImport extends CActiveRecord
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
		return 'hotel_import';
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
            array('hotelid_ppn, hotelid_a, hotelid_b, hotelid_t, hotel_name, hotel_address,
                   city, cityid_ppn, state, state_code, country, country_code, latitude, 
                   longitude, area_id, postal_code, star_rating, low_rate, currency_code,
                   review_rating, review_count, rank_score_ppn, chain_id_ppn, thumbnail,
                   has_photos, room_count, check_in, check_out, property_description,
                   amenity_codes, active, mod_date_time',
                   'length', 'max'=>255),
        );
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Business the static model class
     * 
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
