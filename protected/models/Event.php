<?php

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $event_id
 * @property string $event_title
 * @property string $event_description
 * @property string $event_type
 * @property string $event_start_date
 * @property string $event_end_date
 * @property string $event_start_time
 * @property string $event_end_time
 * @property string $event_frequency
 * @property string $event_address1
 * @property string $event_address2
 * @property string $event_street
 * @property integer $event_city_id
 * @property string $event_phone_no
 * @property string $event_show_map
 * @property string $event_photo
 * @property integer $event_category_id
 * @property integer $event_business_id
 * @property string $event_latitude
 * @property string $event_longitude
 * @property string $event_tag
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $is_featured
 * @property string $is_popular
 * @property string $event_status
 * @property string $cost
 * @property integer $event_views
 * @property string $external_event_source
 * @property string $external_event_id
 *
 * The followings are the available model relations:
 * @property Business $eventBusiness
 * @property City $eventCity
 * @property User $createdBy
 * @property User $modifiedBy
 * @property UserEvent[] $userEvents
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $event = Event::model()
 * ...or
 * ...   $event = new Event;
 * ...or
 * ...   $event = new Event($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Event extends CActiveRecord
{

    /**
     *
     * @var string fldUploadImage Business image uploader.
     * @access public
     */
    public $fldUploadImage;

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
		return '{{event}}';
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
			array('event_title, event_start_date,event_end_date,
			       event_category_id, event_business_id,
			       event_tag',                                            'required'),

		    // Data types, sizes
		    array('event_city_id, event_category_id, event_business_id',  'numerical', 'integerOnly'=>true),
			array('event_title, cost',                                    'length', 'max'=>255),
		    array('event_frequency',                                      'length', 'max'=>64),
		    array('event_address1, event_address2, event_description',    'length', 'max'=>1024),
		    array('event_street, event_start_time, event_end_time',       'length', 'max'=>512),
		    array('event_phone_no',                                       'length', 'max'=>32),
		    array('event_latitude, event_longitude',                      'length', 'max'=>10),
		    array('external_event_source, external_event_id',             'length', 'max'=>255),

		    // ranges
		    array('is_featured, event_show_map,
		           is_featured, is_popular',                     'in','range'=>array('Y','N'),'allowEmpty'=>true),
			array('event_type',                                  'in','range'=>array('public', 'private', 'meetups'),'allowEmpty'=>true),
		    array('event_status',                                'in','range'=>array('Inactive', 'Active','Closed', 'Cancelled'),'allowEmpty'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('event_id, event_title, event_description, event_type,
			       event_start_date, event_start_time, event_address1, event_address2,
			       event_street, event_city_id, event_phone_no,
			       event_category_id, event_business_id,event_tag, created_time, created_by,
			       modified_by, is_featured, is_popular, event_status, cost, event_views,
			       external_event_source, external_event_id',             'safe', 'on'=>'search'),
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
		    'eventBusiness'      => array(self::BELONGS_TO,  'Business', 'event_business_id'),
			'eventCity'          => array(self::BELONGS_TO,  'City', 'event_city_id'),
			'createdBy'          => array(self::BELONGS_TO,  'User', 'created_by'),
			'modifiedBy'         => array(self::BELONGS_TO,  'User', 'modified_by'),
			'userEvents'         => array(self::HAS_MANY,    'UserEvent', 'event_id'),
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
			'event_id'               => 'Event',
			'event_title'            => 'Event Title',
			'event_description'      => 'Event Description',
			'event_type'             => 'Event Type',
			'event_start_date'       => 'Event Start Date',
			'event_end_date'         => 'Event End Date',
			'event_start_time'       => 'Event Start Time',
			'event_end_time'         => 'Event End Time',
			'event_frequency'        => 'Event Frequency',
			'event_address1'         => 'Event Address1',
			'event_address2'         => 'Event Address2',
			'event_street'           => 'Event Street',
			'event_city_id'          => 'Event City',
			'event_phone_no'         => 'Event Phone No',
			'event_show_map'         => 'Event Show Map',
			'event_photo'            => 'Event Photo',
			'event_category_id'      => 'Event Category',
			'event_business_id'      => 'Event Business',
			'event_latitude'         => 'Event Latitude',
			'event_longitude'        => 'Event Longitude',
			'event_tag'              => 'Event Tag',
			'is_featured'            => 'Is Featured',
			'is_popular'             => 'Is Popular',
			'event_status'           => 'Event Status',
			'cost'                   => 'Cost',
			'event_views'            => 'Event Views',
		    'external_event_source'  => 'External Event Source',
		    'external_event_id'      => 'External Event',
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

		$criteria->compare('event_id',            $this->event_id);
		$criteria->compare('event_title',         $this->event_title,true);
		$criteria->compare('event_description',   $this->event_description,true);
		$criteria->compare('event_type',          $this->event_type,true);
		$criteria->compare('event_start_date',    $this->event_start_date,true);
		$criteria->compare('event_end_date',      $this->event_end_date,true);
		$criteria->compare('event_start_time',    $this->event_start_time,true);
		$criteria->compare('event_end_time',      $this->event_end_time,true);
		$criteria->compare('event_frequency',     $this->event_frequency,true);
		$criteria->compare('event_address1',      $this->event_address1,true);
		$criteria->compare('event_address2',      $this->event_address2,true);
		$criteria->compare('event_street',        $this->event_street,true);
		$criteria->compare('event_city_id',       $this->event_city_id);
		$criteria->compare('event_phone_no',      $this->event_phone_no,true);
		$criteria->compare('event_show_map',      $this->event_show_map,true);
		$criteria->compare('event_photo',         $this->event_photo,true);
		$criteria->compare('event_category_id',   $this->event_category_id);
		$criteria->compare('event_business_id',   $this->event_business_id);
		$criteria->compare('event_latitude',      $this->event_latitude,true);
		$criteria->compare('event_longitude',     $this->event_longitude,true);
		$criteria->compare('event_tag',           $this->event_tag,true);
		$criteria->compare('created_time',        $this->created_time,true);
		$criteria->compare('modified_time',       $this->modified_time,true);
		$criteria->compare('created_by',          $this->created_by);
		$criteria->compare('modified_by',         $this->modified_by);
		$criteria->compare('is_featured',         $this->is_featured,true);
		$criteria->compare('is_popular',          $this->is_popular,true);
		$criteria->compare('event_status',        $this->event_status,true);
		$criteria->compare('cost',                $this->cost,true);
		$criteria->compare('event_views',         $this->event_views);
		$criteria->compare('external_event_source',$this->external_event_source);
		$criteria->compare('external_event_id',   $this->external_event_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Event the static model class
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
	public function beforeSave()
	{


        // /////////////////////////////////////////////////////////////////
        // Set the create time and user for new records
        // /////////////////////////////////////////////////////////////////
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
            $this->created_by   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
        }

        // /////////////////////////////////////////////////////////////////
        // The modified log details is set for record creation and update
        // /////////////////////////////////////////////////////////////////
        $this->modified_time = new CDbExpression('NOW()');
        $this->modified_by   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
	    return parent::beforeSave();
	}

	/**
	 * Build an associative list of status values.
	 *
	 * @param <none> <none>
	 * @return array associatve list of permission status values
	 *
	 * @access public
	 */
	public function listStatus()
	{

	    return array('Inactive'    => 'Inactive',
	                 'Active'      => 'Active',
	                 'Closed'      => 'Closed',
	        	     'Cancelled'   => 'Cancelled');
	}

	/**
	 * Build an associative list of event type values.
	 *
	 * @param <none> <none>
	 * @return array associatve list of permission status values
	 *
	 * @access public
	 */
	public function listEventTypes()
	{

	    // TODO: Confirm that meetups is out of scope
	    // return array('public' =>'Public','private' => 'Private','meetups' => 'Meetups');
	    return array('public' =>'Public','private' => 'Private');
	}
}
