<?php

/**
 * This is the model class for table "{{city}}".
 *
 * The followings are the available columns in table '{{city}}':
 * @property integer $city_id
 * @property string $city_name
 * @property string $city_alternate_name
 * @property integer $state_id
 * @property string $time_zone
 * @property string $is_featured
 * @property string $isactive
 * @property string $description
 * @property string $more_information
 * @property string $image
 *
 * The followings are the available model relations:
 * @property Business[] $businesses
 * @property State $state
 * @property Event[] $events
 * @property PlacesSubscribed[] $placesSubscribeds
 * @property PlacesVisited[] $placesVisiteds
 */
class City extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{city}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state_id, description, more_information', 'required'),
			array('state_id', 'numerical', 'integerOnly'=>true),
			array('city_name', 'length', 'max'=>512),
			array('city_alternate_name', 'length', 'max'=>1024),
			array('time_zone', 'length', 'max'=>50),
			array('is_featured, isactive', 'length', 'max'=>1),
			array('image', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, city_name, city_alternate_name, state_id, time_zone, is_featured, isactive, description, more_information, image', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'businesses' => array(self::HAS_MANY, 'Business', 'business_city_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
			'events' => array(self::HAS_MANY, 'Event', 'event_city_id'),
			'placesSubscribeds' => array(self::HAS_MANY, 'PlacesSubscribed', 'city_id'),
			'placesVisiteds' => array(self::HAS_MANY, 'PlacesVisited', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'City',
			'city_name' => 'City Name',
			'city_alternate_name' => 'City Alternate Name',
			'state_id' => 'State',
			'time_zone' => 'Time Zone',
			'is_featured' => 'Is Featured',
			'isactive' => 'Isactive',
			'description' => 'Description',
			'more_information' => 'More Information',
			'image' => 'Image',
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
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('city_alternate_name',$this->city_alternate_name,true);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('time_zone',$this->time_zone,true);
		$criteria->compare('is_featured',$this->is_featured,true);
		$criteria->compare('isactive',$this->isactive,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('more_information',$this->more_information,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
