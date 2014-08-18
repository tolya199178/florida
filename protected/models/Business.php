<?php

/**
 * This is the model class for table "{{business}}".
 *
 * The followings are the available columns in table '{{business}}':
 * @property integer $business_id
 * @property string $business_name
 * @property string $business_address1
 * @property string $business_address2
 * @property integer $business_city_id
 * @property string $business_zipcode
 * @property string $business_phone_ext
 * @property string $business_phone
 * @property string $business_email
 * @property string $business_website
 * @property string $business_description
 * @property string $image
 * @property string $business_allow_review
 * @property string $business_allow_rating
 * @property string $business_keywords
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $add_request_processing_status
 * @property string $add_request_processing_time
 * @property integer $add_request_processed_by
 * @property string $add_request_rejection_reason
 * @property string $claim_status
 * @property string $claim_processing_time
 * @property integer $claimed_by
 * @property string $claim_rejection_reason
 * @property string $is_active
 * @property string $is_featured
 * @property string $is_closed
 * @property string $activation_code
 * @property string $activation_status
 * @property string $activation_time
 * @property string $latitude
 * @property string $longitude
 * @property string $business_type
 * @property integer $star_rating
 * @property double $low_rate
 * @property integer $room_count
 * @property string $opening_time
 * @property string $closing_time
 * @property string $import_reference
 * @property string $import_source
 * @property string $is_for_review
 * @property string $report_closed_reference
 * @property integer $report_closed_by
 * @property string $report_closed_date
* @property string $contact
 *
 *
 * The followings are the available model relations:
 * @property City $businessCity
 * @property User $claimedBy
 * @property User $createdBy
 * @property User $modifiedBy
 * @property User $addRequestProcessedBy
 * @property BusinessActivity[] $businessActivities
 * @property BusinessCategory[] $businessCategories
 * @property BusinessUser[] $businessUsers
 * @property Event[] $events
 * @property RestaurantCertificate[] $restaurantCertificates
 * @property SubscribedBusiness[] $subscribedBusinesses
 * @property BusinessReviews[] $businessReviews
 * @property Coupon[] $coupons
 * @property BusinessAnnouncement[] $businessAnnouncements
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $business = Business::model()
 * ...or
 * ...   $business = new Business;
 * ...or
 * ...   $business = new Business($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Business extends CActiveRecord
{
    /**
     * Form only comma-seperated list of business activities
     * @var string fldUploadImage Business image uploader.
     * @access public
     */
    public $business_activities;

    /**
     *
     * @var string fldUploadImage Business image uploader.
     * @access public
     */
    public $fldUploadImage;

    /**
     *
     * @var string read-only (non-db field) for url of business image.
     * @access public
     */
    public $imgUrl;

    /**
     *
     * @var string read-only (non-db field) for full url of business thumbnail.
     * @access public
     */
    public $thumbnailUrl;

    /**
     *
     * @var array list of assigned category (ids), fk to categories table
     * @access public
     */
    public $lstBusinessCategories;


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
		return '{{business}}';
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

			array('business_name', 'required'),

		    // Data types, sizes
		    array('business_name, business_email, business_website, add_request_rejection_reason, claim_rejection_reason, activation_code', 'length', 'max'=>255),
			array('business_zipcode, business_phone, business_phone_ext',        'length', 'max'=>16),
		    array('business_address1, business_address2, business_description,
		           business_keywords, report_closed_reference',                  'length', 'max'=>4096),
		    array('add_request_rejection_reason, claim_rejection_reason',        'length', 'max'=>255),

		    array('business_activities',                                         'length', 'max'=>255),

		    array('latitude',                                                     'numerical',  'min'=>-90,  'max'=>90),
		    array('longitude',                                                    'numerical',  'min'=>-180, 'max'=>180),

		    array('room_count',                                                   'numerical', 'integerOnly'=>true),
		    array('low_rate',                                                     'numerical'),
		    array('business_type',                                                'length', 'max'=>128),
		    array('opening_time, closing_time',                                   'length', 'max'=>255),
		    array('import_reference, import_source',                              'length', 'max'=>255),
		    array('contact',                                                      'length', 'max'=>1024),

		    // ranges
			array('business_allow_review,
			       business_allow_rating, is_active,
			       is_featured, is_for_review',           'in','range'=>array('Y','N'),'allowEmpty'=>false),
		    array('is_closed',                            'in','range'=>array('Y','N','Pending'),'allowEmpty'=>false),

		    array('claim_status',                         'in','range'=>array('Claimed', 'Unclaimed'),'allowEmpty'=>false),
		    array('activation_status',                    'in','range'=>array('activated', 'not_activated'),'allowEmpty'=>false),
		    array('add_request_processing_status',        'in','range'=>array('Accepted', 'Rejected'),'allowEmpty'=>false),

		    // Form only attributes.
		    array('fldUploadImage',                       'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),


            // The following rule is used by search(). It only contains attributes that should be searched.
			array('business_id, business_name, business_address1, business_address2, business_city_id, business_zipcode,
			       business_phone_ext, business_phone, business_email, business_website, business_description,
			       business_allow_review, business_allow_rating, business_keywords, created_time, modified_time,
			       created_by, modified_by, add_request_processing_status, add_request_processing_time,
			       add_request_processed_by, add_request_rejection_reason, claim_status, claim_processing_time,
			       claimed_by, claim_rejection_reason, is_active, is_featured, is_closed, activation_code,
			       activation_status, activation_time, star_rating, room_count, business_type
			       low_rate, opening_time, closing_time, contact', 'safe', 'on'=>'search'),
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
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		    'businessAnnouncements'  => array(self::HAS_MANY,   'BusinessAnnouncement', 'business_id'),
			'businessCity'           => array(self::BELONGS_TO, 'City', 'business_city_id'),
			'claimedBy'              => array(self::BELONGS_TO, 'User', 'claimed_by'),
			'createdBy'              => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy'             => array(self::BELONGS_TO, 'User', 'modified_by'),
			'addRequestProcessedBy'  => array(self::BELONGS_TO, 'User', 'add_request_processed_by'),
		    'businessActivities'     => array(self::HAS_MANY,   'BusinessActivity', 'business_id'),
		    'businessCategories'     => array(self::HAS_MANY,   'BusinessCategory', 'business_id'),
			'businessUsers'          => array(self::HAS_MANY,   'BusinessUser', 'business_id'),
		    'events'                 => array(self::HAS_MANY,   'Event', 'event_business_id'),
			'restaurantCertificates' => array(self::HAS_MANY,   'RestaurantCertificate', 'business_id'),
		    'subscribedBusinesses'   => array(self::HAS_MANY,   'SubscribedBusiness', 'business_id'),
		    'businessReviews'        => array(self::HAS_MANY,   'BusinessReview', 'business_id'),
		    'reportClosedBy'         => array(self::BELONGS_TO, 'User', 'report_closed_by'),
		    'coupons'                => array(self::HAS_MANY,   'Coupon', 'business_id'),
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
			'business_id'                        => 'Business',
			'business_name'                      => 'Business Name',
			'business_address1'                  => 'Business Address1',
			'business_address2'                  => 'Business Address2',
			'business_city_id'                   => 'Business City',
			'business_zipcode'                   => 'Business Zipcode',
			'business_phone_ext'                 => 'Business Phone Ext',
			'business_phone'                     => 'Business Phone',
			'business_email'                     => 'Business Email',
			'business_website'                   => 'Business Website',
			'business_description'               => 'Business Description',
			'image'                              => 'Business Image',
			'business_allow_review'              => 'Business Allow Review',
			'business_allow_rating'              => 'Business Allow Rating',
			'business_keywords'                  => 'Business Keywords',
			'add_request_processing_status'      => 'Add Request Processing Status',
			'add_request_rejection_reason'       => 'Add Request Rejection reason',
			'claim_status'                       => 'Claim Status',
			'claimed_by'                         => 'Claimed By',
			'claim_rejection_reason'             => 'Claim Rejection reason',
			'is_active'                          => 'Is Active',
			'is_featured'                        => 'Is Featured',
			'is_closed'                          => 'Is Closed',
			'activation_code'                    => 'Activation Code',
			'activation_status'                  => 'Activation Status',
		    'latitude'                           => 'Latitude',
		    'longitude'                          => 'Longitude',
		    'business_type'                      => 'Business Type',
		    'star_rating'                        => 'Star Rating',
		    'low_rate'                           => 'Low Rate',
		    'room_count'                         => 'Room Count',
		    'opening_time'                       => 'Opening Time',
		    'closing_time'                       => 'Closing Time',
		    'import_reference'                   => 'Import Reference',
		    'import_source'                      => 'Import Source',
		    'is_for_review'                      => 'For Review',
		    'report_closed_reference'            => 'Report Closed Reference',
		    'report_closed_by'                   => 'Report Closed By',
		    'report_closed_date'                 => 'Report Closed Date',
		    'contact'                            => 'Contact',
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

		$criteria->compare('business_id',                     $this->business_id);
		$criteria->compare('business_name',                   $this->business_name,true);
		$criteria->compare('business_address1',               $this->business_address1,true);
		$criteria->compare('business_address2',               $this->business_address2,true);
		$criteria->compare('business_city_id',                $this->business_city_id);
		$criteria->compare('business_zipcode',                $this->business_zipcode);
		$criteria->compare('business_phone',                  $this->business_phone,true);
		$criteria->compare('business_email',                  $this->business_email,true);
		$criteria->compare('business_website',                $this->business_website,true);
		$criteria->compare('business_description',            $this->business_description,true);
		$criteria->compare('business_allow_review',           $this->business_allow_review);
		$criteria->compare('business_allow_rating',           $this->business_allow_rating);
		$criteria->compare('business_keywords',               $this->business_keywords,true);
		$criteria->compare('created_time',                    $this->created_time,true);
		$criteria->compare('modified_time',                   $this->modified_time,true);
		$criteria->compare('created_by',                      $this->created_by);
		$criteria->compare('modified_by',                     $this->modified_by);
		$criteria->compare('add_request_processing_status',   $this->add_request_processing_status);
		$criteria->compare('add_request_processing_time',     $this->add_request_processing_time,true);
		$criteria->compare('add_request_processed_by',        $this->add_request_processed_by);
		$criteria->compare('add_request_rejection_reason',    $this->add_request_rejection_reason,true);
		$criteria->compare('claim_status',                    $this->claim_status);
		$criteria->compare('claim_processing_time',           $this->claim_processing_time,true);
		$criteria->compare('claimed_by',                      $this->claimed_by);
		$criteria->compare('claim_rejection_reason',          $this->claim_rejection_reason,true);
		$criteria->compare('is_active',                       $this->is_active);
		$criteria->compare('is_featured',                     $this->is_featured);
		$criteria->compare('is_closed',                       $this->is_closed);
		$criteria->compare('activation_code',                 $this->activation_code,true);
		$criteria->compare('activation_status',               $this->activation_status);
		$criteria->compare('activation_time',                 $this->activation_time,true);
		$criteria->compare('latitude',                        $this->latitude,true);
		$criteria->compare('longitude',                       $this->longitude,true);
		$criteria->compare('business_type',                   $this->business_type,true);
		$criteria->compare('star_rating',                     $this->star_rating);
		$criteria->compare('low_rate',                        $this->low_rate);
		$criteria->compare('room_count',                      $this->room_count);
		$criteria->compare('opening_time',                    $this->opening_time,true);
		$criteria->compare('closing_time',                    $this->closing_time,true);
		$criteria->compare('import_reference',                $this->import_reference);
		$criteria->compare('import_source',                   $this->import_source);
		$criteria->compare('is_for_review',                   $this->is_for_review);
		$criteria->compare('report_closed_reference',         $this->report_closed_reference,true);
		$criteria->compare('report_closed_by',                $this->report_closed_by);
		$criteria->compare('report_closed_date',              $this->report_closed_date);
		$criteria->compare('contact',                         $this->contact);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

        if ($this->scenario == 'report_closed')
        {
            $this->report_closed_by     = $this->modified_by;
            $this->report_closed_date   = new CDbExpression('NOW()');
        }

	    return parent::beforeSave();
	}

	/**
	 * Runs just after the models save method is invoked. It provides a change to
	 * ...further prepare the data for saving. The CActiveRecord (parent class)
	 * ...beforeSave is called to process any raised events.
	 *
	 * ...We save the assigned categories
	 *
	 * @param <none> <none>
	 * @return boolean the decision to continue the save or not.
	 *
	 * @access public
	 */
	public function afterSave()
	{

	    // /////////////////////////////////////////////////////////////////////
	    // Save the categories assigned We clear all existing categories and
	    // ...create new ones from the list provided by user input.
	    // The list is provided by an array for category ids.
	    // /////////////////////////////////////////////////////////////////////
	    $dbTransaction = Yii::app()->db->beginTransaction();;
	    try
	    {
	            $modelBusinessCategory = BusinessCategory::model()->deleteAllByAttributes(array('business_id'=> $this->business_id));

	            if (isset($this->lstBusinessCategories) && (count($this->lstBusinessCategories) > 0))
	            {
	                foreach ($this->lstBusinessCategories as $businessCategoryId)
	                {
	                    $modelBusinessCategory = new BusinessCategory;
	                    $modelBusinessCategory->business_id = $this->business_id;
	                    $modelBusinessCategory->category_id = $businessCategoryId;

	                    $modelBusinessCategory->save();
	                }
	            }

	            $dbTransaction->commit();
	    }
	    catch(Exception $e) // an exception is raised if a query fails
	    {
	        $dbTransaction->rollback();
	        throw new CHttpException(405,'Something went wrong trying to replace business categories.');
	    }


	    // /////////////////////////////////////////////////////////////////////
	    // Save the activties assigned to the business. We clear all existing
	    // ...activities and re-assign create new ones from the user input.
	    // The list is provided as a comma-delimited string.
	    // /////////////////////////////////////////////////////////////////////
	   $dbTransaction = Yii::app()->db->beginTransaction();;
	    try
	    {
	        $modelBusinessactivity = BusinessActivity::model()->deleteAllByAttributes(array('business_id'=> $this->business_id));

	        if (!empty($this->business_activities))
	        {
	            $lstActivityType = explode(",", $this->business_activities);

	            foreach ($lstActivityType as $activityType)
	            {
	                // /////////////////////////////////////////////////////////
	                // We were provided with the activity type. From this we
	                // ...obtain the activity id and activity type id.
	                // /////////////////////////////////////////////////////////
	                $activityTypeModel = ActivityType::model()->findByPk((int) $activityType);

	                if ($activityTypeModel != null)
	                {
                        $modelBusinessactivity                      = new BusinessActivity();
                        $modelBusinessactivity->business_id         = $this->business_id;
                        $modelBusinessactivity->activity_id         = $activityTypeModel->activity_id;
                        $modelBusinessactivity->activity_type_id    = $activityType;

                        $modelBusinessactivity->save();

	                }

	            }

	        }

	        $dbTransaction->commit();
 	    }
 	    catch(Exception $e) // an exception is raised if a query fails
 	    {
 	        $dbTransaction->rollback();
 	        throw new CHttpException(405,'Something went wrong trying to replace business activities.');
 	    }


	    return parent::afterSave();
	}

	/**
	 * Build an associative list of Add Request processing Values.
	 *
	 * @param <none> <none>
	 * @return array associatve list of user type values
	 *
	 * @access public
	 */
	public function listAddRequestProcessingStatus() {

	    return array(  'Accepted'       => 'Accepted',
	                   'Rejected'       => 'Rejected',
                    );
	}

	/**
	 * Build an associative list of Claim Status values
	 * @param <none> <none>
	 * @return array associatve list of user type values
	 *
	 * @access public
	 */
	public function listClaimStatus() {

	    return array('Claimed'         => 'Claimed',
	                 'Unclaimed'       => 'Unclaimed',
	                );
	}

	/**
	 * Build an associative list of activation status values.
	 *
	 * @param <none> <none>
	 * @return array associatve list of user type values
	 *
	 * @access public
	 */
	public function listActivationStatus() {

	    return array(  'activated'         => 'Activated',
	                   'not_activated'     => 'Not Activated',
	    );
	}

	/**
	 * Getter function for virtual attribute $thumbnailUrl
	 *
	 * @param <none> <none>
	 * @return string url of business image thumbnail
	 *
	 * @access public
	 */
	public function getThumbnailUrl()
	{

	    if(filter_var($this->image, FILTER_VALIDATE_URL))
	    {
	        $thumbnailUrl = $this->image;
	    }
	    else
	    {
	        $thumbnailsDirUrl     = Yii::app()->request->baseUrl.'/uploads/images/business/thumbnails';
	        $thumbnailUrl         = $thumbnailsDirUrl.DIRECTORY_SEPARATOR.$this->image;
	    }

        // Set the attribute
	    $this->thumbnailUrl = $thumbnailUrl;

	    return $thumbnailUrl;

	}

	/**
	 * Getter function for virtual attribute $imgUrl
	 *
	 * @param <none> <none>
	 * @return string url of business image
	 *
	 * @access public
	 */
	public function getImgUrl()
	{

	    if(filter_var($this->image, FILTER_VALIDATE_URL))
	    {
	        $imageUrl = $this->image;
	    }
	    else
	    {
    	    $imagesDirUrl         = Yii::app()->request->baseUrl.'/uploads/images/business';
    	    $imageUrl             = $imagesDirUrl.DIRECTORY_SEPARATOR.$this->image;
	    }

	    // Set the attribute
	    $this->imgUrl = $imageUrl;

	    return $imageUrl;

	}

}
