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
 * @property string $latitude
 * @property string $longitude
 *
 * The followings are the available model relations:
 * @property Business[] $businesses
 * @property State $state
 * @property Event[] $events
 * @property PlacesSubscribed[] $placesSubscribeds
 * @property PlacesVisited[] $placesVisiteds
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $city = City::model()
 * ...or
 * ...   $city = new City;
 * ...or
 * ...   $city = new City($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class City extends CActiveRecord
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
		return '{{city}}';
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

		    // Mandatory rules
			array('description, more_information',     'required'),

		    // Data types, sizes
			array('state_id', 'numerical',                       'integerOnly'=>true),
		    array('city_name', 'length',                         'max'=>512),
			array('city_alternate_name',                         'length', 'max'=>1024),
			array('time_zone',                                   'length', 'max'=>50),

		    // ranges
			array('is_featured, isactive',                       'in','range'=>array('Y','N'),'allowEmpty'=>false),

			array('image',                                        'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),

		    array('latitude',                                    'numerical',  'min'=>-90,  'max'=>90),
		    array('longitude',                                   'numerical',  'min'=>-180, 'max'=>180),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('city_id, city_name, city_alternate_name,
			       state_id, is_featured, isactive, description','safe', 'on'=>'search'),
		);
	}

    /**
     * Set rules for the relation of this record model to other record models.
     *
     * @param <none> <none>
     *
     * @return array relational rules.
     * @access public
     */
	public function relations()
	{

		return array(
			'businesses'         => array(self::HAS_MANY,    'Business', 'business_city_id'),
			'state'              => array(self::BELONGS_TO,  'State', 'state_id'),
			'events'             => array(self::HAS_MANY,    'Event', 'event_city_id'),
			'placesSubscribeds'  => array(self::HAS_MANY,    'PlacesSubscribed', 'city_id'),
			'placesVisiteds'     => array(self::HAS_MANY,    'PlacesVisited', 'city_id'),
		);
	}

    /**
     * Label set for attributes. Only required for attributes that appear on view/forms.
     * ...
     * Usage:
     *    echo $form->label($model, $attribute)
     *
     * @param <none> <none>
     *
     * @return array customized attribute labels (name=>label)
     * @access public
     */
	public function attributeLabels()
	{
		return array(
			'city_id'                => 'City',
			'city_name'              => 'City Name',
			'city_alternate_name'    => 'City Alternate Name',
			'state_id'               => 'State',
			'time_zone'              => 'Time Zone',
			'is_featured'            => 'Is Featured',
			'isactive'               => 'Isactive',
			'description'            => 'Description',
			'more_information'       => 'More Information',
			'image'                  => 'Image',
		    'latitude'               => 'Latitude',
		    'longitude'              => 'Longitude',
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

		$criteria=new CDbCriteria;

		$criteria->compare('city_id',                 $this->city_id);
		$criteria->compare('city_name',               $this->city_name,true);
		$criteria->compare('city_alternate_name',     $this->city_alternate_name,true);
		$criteria->compare('state_id',                $this->state_id);
		$criteria->compare('is_featured',             $this->is_featured,true);
		$criteria->compare('isactive',                $this->isactive,true);
		$criteria->compare('description',             $this->description,true);
		$criteria->compare('latitude',                $this->latitude,true);
		$criteria->compare('longitude',               $this->longitude,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return City the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Runs just before the models save method is invoked. It provides a change to
	 * ...further prepare the data for saving. The CActiveRecord (parent class)
	 * ...beforeSave is called to process any raised events.
	 *
	 * @param <none> <none>
	 * @return boolean the decision to continue the save or not.
	 *
	 * @access public
	 */
	public function beforeSave() {

	    // Force the state to be the first entry in the country table.
	    // Used for forced implemantations where state details are hidden or implied.
	    if ($this->isNewRecord) {

	        $stateModel = State::model()->findByAttributes(array('state_name' => Yii::app()->params['STATE']));

	        if ($stateModel === null) {
	            $this->state_id = 1;
	        }
	        else {
	            $this->state_id = $stateModel->attributes['state_id'];
	        }
	    }


	    return parent::beforeSave();
	}

	/* Get List of City Array Data */
	public static function getCity($order = "city_name",$byAutoSearch=0) {
	    $order = array('order' => $order);
	    $models = self::model()->findAll($order);

	    $_rtnData = CHtml::listData($models, 'city_id', 'city_name');
	    return $byAutoSearch ? array_values($_rtnData) : $_rtnData;

	}

	/**
	 * Generates a JSON encoded list of all citys.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function getListjson() {



	    // /////////////////////////////////////////////////////////////////////
	    // Create a Db Criteria to filter and customise the resulting results
	    // /////////////////////////////////////////////////////////////////////
	    $searchCriteria = new CDbCriteria;

	    $cityList          = City::model()->findAll($searchCriteria);



	    $listResults = array();

	    foreach($cityList as $recCity){
	         $listResults[] = array('city_name' => $recCity->attributes['city_name']);
	       // $listResults[] = $recCity->attributes['city_name'];
	    }
	    // header('Content-type: application/json');

	    // echo json_encode($listResults);
	    return CJSON::encode($listResults);



	}

}
