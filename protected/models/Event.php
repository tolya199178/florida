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
 * @property integer $user_id
 * @property integer $event_venue_ref
 * @property string $venue_box_office_phone
 * @property string $venue_directions
 * @property string $venue_parking
 * @property string $venue_public_ransportation
 * @property string $venue_url
 * @property string $zip_code
 * @property string $venue_capacity
 * @property string $venue_rules
 * @property string $venue_child_rules
 * @property string $tn_Notes
 * @property string $venue_interactive_url
 * @property string $event_url
 *
 * The followings are the available model relations:
 * @property EventCategory $eventCategory
 * @property Business $eventBusiness
 * @property EventCategory $eventCategory
 * @property City $eventCity
 * @property User $createdBy
 * @property User $modifiedBy
 * @property UserEvent[] $userEvents
 * @property User $user
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
     * @var string fldUploadImage event image uploader.
     * @access public
     */
    public $fldUploadImage;

    /**
     *
     * @var string read-only (non-db field) for url of event image.
     * @access public
     */
    public $imgUrl;

    /**
     *
     * @var string read-only (non-db field) for full url of event thumbnail.
     * @access public
     */
    public $thumbnailUrl;

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
		    array('event_city_id, event_category_id, event_business_id,
		           event_venue_ref',                                      'numerical', 'integerOnly'=>true),
			array('event_title, cost',                                    'length', 'max'=>255),
		    array('event_frequency',                                      'length', 'max'=>64),
		    array('event_address1, event_address2, event_description',    'length', 'max'=>1024),
		    array('event_street, event_start_time, event_end_time',       'length', 'max'=>512),
		    array('event_phone_no',                                       'length', 'max'=>32),
		    array('event_latitude, event_longitude',                      'length', 'max'=>10),
		    array('external_event_source',                                'length', 'max'=>255),
		    array('external_event_id',                                    'length', 'max'=>64),

		    array('venue_box_office_phone, venue_rules , venue_parking,
		           venue_public_ransportation, venue_url, zip_code,
		           venue_capacity, venue_child_rules, event_url,
		           venue_interactive_url',                                'length', 'max'=>255),

		    array('venue_directions, notes',                               'length', 'max'=>4096),

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
			       external_event_source, external_event_id, user_id',    'safe', 'on'=>'search'),
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
		    'user'               => array(self::BELONGS_TO,  'User', 'user_id'),
		    'eventCategory'      => array(self::BELONGS_TO,  'EventCategory', 'event_category_id'),
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
		    'user_id'                => 'User',
		    'event_venue_ref'        => 'Event Venue',
			'venue_box_office_phone' => 'Venue Box Office Phone',
			'venue_directions'       => 'Venue Directions',
			'venue_parking'          => 'Venue Parking',
			'venue_public_ransportation' => 'Venue Public Ransportation',
			'venue_url'              => 'Venue Url',
			'zip_code'               => 'Zip Code',
			'venue_capacity'         => 'Venue Capacity',
			'venue_rules'            => 'Venue Rules',
			'venue_child_rules'      => 'Venue Child Rules',
			'tn_Notes'               => 'Tn Notes',
		    'venue_interactive_url'      => 'Venue Interactive Url',
		    'event_url'      => 'Event Url',
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
		$criteria->compare('external_event_source',   $this->external_event_source);
		$criteria->compare('external_event_id',   $this->external_event_id,true);
		$criteria->compare('user_id',             $this->user_id);
		$criteria->compare('event_venue_ref',     $this->event_venue_ref);
		$criteria->compare('venue_box_office_phone',  $this->venue_box_office_phone,true);
		$criteria->compare('venue_directions',    $this->venue_directions,true);
		$criteria->compare('venue_parking',       $this->venue_parking,true);
		$criteria->compare('venue_public_ransportation',  $this->venue_public_ransportation,true);
		$criteria->compare('venue_url',           $this->venue_url,true);
		$criteria->compare('zip_code',            $this->zip_code,true);
		$criteria->compare('venue_capacity',      $this->venue_capacity,true);
		$criteria->compare('venue_rules',         $this->venue_rules,true);
		$criteria->compare('venue_child_rules',   $this->venue_child_rules,true);
		$criteria->compare('tn_Notes',            $this->tn_Notes,true);
		$criteria->compare('venue_interactive_url',   $this->venue_interactive_url,true);
		$criteria->compare('event_url',           $this->event_url,true);

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

	    // /////////////////////////////////////////////////////////////////////
	    // All events are public events. The event type will retain the event
	    // ...type (RFU). The event_type valuse for all new records will be
	    // ...automatically be set to 'public'
	    // /////////////////////////////////////////////////////////////////////
	    if ($this->isNewRecord) {
	        $this->event_type = 'Public';
	    }

        // /////////////////////////////////////////////////////////////////
        // Set the create time and user for new records
        // /////////////////////////////////////////////////////////////////
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
            $this->created_by   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
            $this->user_id      = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
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

	/**
	 * Build an associative list of event times in 30 minute intervals.
	 *
	 * @param <none> <none>
	 * @return array associatve list of permission status values
	 *
	 * @access public
	 */
	public function listEventStartEndTimes()
	{

	    // TODO: Confirm that meetups is out of scope
	    // return array('public' =>'Public','private' => 'Private','meetups' => 'Meetups');
	    return array('00:00' =>'00:00 (Midnight)',
	                 '00:30' =>'00:30',
	                 '01:00' =>'00:00',
	                 '01:30' =>'00:30',
        	         '02:00' =>'02:00',
        	         '02:30' =>'02:30',
        	         '03:00' =>'03:00',
        	         '03:30' =>'03:30',
        	         '04:00' =>'04:00',
        	         '04:30' =>'04:30',
        	         '05:00' =>'05:00',
        	         '05:30' =>'05:30',
         	         '06:00' =>'06:00',
        	         '06:30' =>'06:30',
        	         '07:00' =>'07:00',
        	         '07:30' =>'07:30',
        	         '08:00' =>'08:00',
        	         '08:30' =>'08:30',
        	         '09:00' =>'09:00',
        	         '09:30' =>'09:30',
        	         '10:00' =>'10:00',
        	         '10:30' =>'10:30',
        	         '11:00' =>'11:00',
        	         '11:30' =>'11:30',
        	         '12:00' =>'12:00  (Midday)',
        	         '12:30' =>'12:30',
        	         '13:00' =>'13:00',
        	         '13:30' =>'13:30',
        	         '14:00' =>'14:00',
        	         '14:30' =>'14:30',
        	         '15:00' =>'15:00',
        	         '15:30' =>'15:30',
        	         '16:00' =>'16:00',
        	         '16:30' =>'16:30',
        	         '17:00' =>'17:00',
        	         '17:30' =>'17:30',
        	         '18:00' =>'18:00',
        	         '18:30' =>'18:30',
        	         '19:00' =>'19:00',
        	         '19:30' =>'19:30',
        	         '20:00' =>'20:00',
        	         '20:30' =>'20:30',
        	         '21:00' =>'21:00',
        	         '21:30' =>'21:30',
        	         '22:00' =>'22:00',
        	         '22:30' =>'22:30',
        	         '23:00' =>'23:00',
        	         '23:30' =>'23:30',
	           );
	}

	/**
	 * Getter function for virtual attribute $thumbnailUrl
	 *
	 * @param <none> <none>
	 * @return string url of event image thumbnail
	 *
	 * @access public
	 */
	public function getThumbnailUrl()
	{

	    $thumbnailsDirUrl     = Yii::app()->request->baseUrl.'/uploads/images/event/thumbnails';
	    $thumbnailUrl         = $thumbnailsDirUrl.DIRECTORY_SEPARATOR.$this->event_photo;

	    $this->thumbnailUrl = $thumbnailUrl;

	    return $thumbnailUrl;

	}

	/**
	 * Getter function for virtual attribute $imgUrl
	 *
	 * @param <none> <none>
	 * @return string url of event image
	 *
	 * @access public
	 */
	public function getImgUrl()
	{

	    $imagesDirUrl         = Yii::app()->request->baseUrl.'/uploads/images/event';
	    $imageUrl             = $imagesDirUrl.DIRECTORY_SEPARATOR.$this->event_photo;

	    $this->imgUrl = $imageUrl;

	    return $imageUrl;

	}
}
