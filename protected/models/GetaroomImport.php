<?php

/**
 * This is the model class for table "getaroom_import".
 *
 * The followings are the available columns in table 'getaroom_import':
 * @property string $lat
 * @property string $lng
 * @property string $location_city
 * @property string $location_country
 * @property string $location_state
 * @property string $location_street
 * @property string $location_zip
 * @property string $permalink
 * @property string $rating
 * @property string $review_rating
 * @property string $short_description
 * @property string $thumbnail_filename
 * @property string $time_zone
 * @property string $title
 * @property string $uuid
 * @property string $sanitized_description
 * @property string $market
 * @property string $amenity
 * @property string $record_id
 * @property string $source_filename
 * @property string $date_created
 * @property string $import_date
 * @property string $sync_date
 * @property string $import_comment
 * @property string $sync_comment
 */

 /**
 * GetaroomImport activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = GetaroomImport::model()
 * ...or
 * ...   $model = new GetaroomImport;
 * ...or
 * ...   $model = new GetaroomImport($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class GetaroomImport extends CActiveRecord
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
		return 'getaroom_import';
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
			array('lat, lng, date_created',                      'required'),
			array('lat, lng',                                    'length', 'max'=>32),
			array('location_city, location_country, location_state,
			       location_street, location_zip, permalink, rating,
			       review_rating, time_zone, source_filename,
			       import_date, sync_date',                      'length', 'max'=>255),
			array('thumbnail_filename, title, uuid, market',     'length', 'max'=>1024),

			array('short_description, sanitized_description, amenity,
			       import_comment, sync_comment,                 'length', 'max'=>4096),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('lat, lng, location_city, location_country, location_state, location_street, location_zip, permalink, rating, review_rating, short_description, thumbnail_filename, time_zone, title, uuid, sanitized_description, market, amenity, record_id, source_filename, date_created, import_date, sync_date, import_comment, sync_comment', 'safe', 'on'=>'search'),
		);
	}


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @param <none> <none>
     *
     * @return CActiveDataProvider the data provider that can return the models
     *         ...based on the search/filter conditions.
     * @access public
     */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lat',             $this->lat,true);
		$criteria->compare('lng',             $this->lng,true);
		$criteria->compare('location_city',   $this->location_city,true);
		$criteria->compare('location_country',$this->location_country,true);
		$criteria->compare('location_state',  $this->location_state,true);
		$criteria->compare('location_street', $this->location_street,true);
		$criteria->compare('location_zip',    $this->location_zip,true);
		$criteria->compare('permalink',       $this->permalink,true);
		$criteria->compare('rating',          $this->rating,true);
		$criteria->compare('review_rating',   $this->review_rating,true);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('thumbnail_filename',$this->thumbnail_filename,true);
		$criteria->compare('time_zone',       $this->time_zone,true);
		$criteria->compare('title',           $this->title,true);
		$criteria->compare('uuid',            $this->uuid,true);
		$criteria->compare('sanitized_description',$this->sanitized_description,true);
		$criteria->compare('market',          $this->market,true);
		$criteria->compare('amenity',         $this->amenity,true);
		$criteria->compare('record_id',       $this->record_id,true);
		$criteria->compare('source_filename', $this->source_filename,true);
		$criteria->compare('date_created',    $this->date_created,true);
		$criteria->compare('import_date',     $this->import_date,true);
		$criteria->compare('sync_date',       $this->sync_date,true);
		$criteria->compare('import_comment',  $this->import_comment,true);
		$criteria->compare('sync_comment',    $this->sync_comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return GetaroomImport the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
