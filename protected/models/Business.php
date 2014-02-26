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
 * @property string $add_request_rejection_reasom
 * @property string $claim_status
 * @property string $claim_processing_time
 * @property integer $claimed_by
 * @property string $claim_rejection_reasom
 * @property string $is_active
 * @property string $is_featured
 * @property string $is_closed
 * @property string $activation_code
 * @property string $activation_status
 * @property string $activation_time
 *
 * The followings are the available model relations:
 * @property City $businessCity
 * @property User $claimedBy
 * @property User $createdBy
 * @property User $modifiedBy
 * @property User $addRequestProcessedBy
 * @property BusinessUser[] $businessUsers
 * @property RestaurantCertificate[] $restaurantCertificates
 */
class Business extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{business}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_name, modified_time, created_by, modified_by, add_request_processed_by, add_request_rejection_reasom, claimed_by, claim_rejection_reasom', 'required'),
			array('business_city_id, created_by, modified_by, add_request_processed_by, claimed_by', 'numerical', 'integerOnly'=>true),
			array('business_name', 'length', 'max'=>100),
			array('business_zipcode, business_phone', 'length', 'max'=>16),
			array('business_phone_ext', 'length', 'max'=>5),
			array('business_email', 'length', 'max'=>125),
			array('business_website', 'length', 'max'=>150),
			array('business_allow_review, business_allow_rating, is_active, is_featured, is_closed', 'length', 'max'=>1),
			array('add_request_processing_status', 'length', 'max'=>8),
			array('add_request_rejection_reasom, claim_rejection_reasom, activation_code', 'length', 'max'=>255),
			array('claim_status', 'length', 'max'=>9),
			array('activation_status', 'length', 'max'=>13),
			array('business_address1, business_address2, business_description, image, business_keywords, created_time, add_request_processing_time, claim_processing_time, activation_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('business_id, business_name, business_address1, business_address2, business_city_id, business_zipcode, business_phone_ext, business_phone, business_email, business_website, business_description, image, business_allow_review, business_allow_rating, business_keywords, created_time, modified_time, created_by, modified_by, add_request_processing_status, add_request_processing_time, add_request_processed_by, add_request_rejection_reasom, claim_status, claim_processing_time, claimed_by, claim_rejection_reasom, is_active, is_featured, is_closed, activation_code, activation_status, activation_time', 'safe', 'on'=>'search'),
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
			'businessCity' => array(self::BELONGS_TO, 'City', 'business_city_id'),
			'claimedBy' => array(self::BELONGS_TO, 'User', 'claimed_by'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
			'addRequestProcessedBy' => array(self::BELONGS_TO, 'User', 'add_request_processed_by'),
			'businessUsers' => array(self::HAS_MANY, 'BusinessUser', 'business_id'),
			'restaurantCertificates' => array(self::HAS_MANY, 'RestaurantCertificate', 'business_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'business_id' => 'Business',
			'business_name' => 'Business Name',
			'business_address1' => 'Business Address1',
			'business_address2' => 'Business Address2',
			'business_city_id' => 'Business City',
			'business_zipcode' => 'Business Zipcode',
			'business_phone_ext' => 'Business Phone Ext',
			'business_phone' => 'Business Phone',
			'business_email' => 'Business Email',
			'business_website' => 'Business Website',
			'business_description' => 'Business Description',
			'image' => 'Image',
			'business_allow_review' => 'Business Allow Review',
			'business_allow_rating' => 'Business Allow Rating',
			'business_keywords' => 'Business Keywords',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
			'add_request_processing_status' => 'Add Request Processing Status',
			'add_request_processing_time' => 'Add Request Processing Time',
			'add_request_processed_by' => 'Add Request Processed By',
			'add_request_rejection_reasom' => 'Add Request Rejection Reasom',
			'claim_status' => 'Claim Status',
			'claim_processing_time' => 'Claim Processing Time',
			'claimed_by' => 'Claimed By',
			'claim_rejection_reasom' => 'Claim Rejection Reasom',
			'is_active' => 'Is Active',
			'is_featured' => 'Is Featured',
			'is_closed' => 'Is Closed',
			'activation_code' => 'Activation Code',
			'activation_status' => 'Activation Status',
			'activation_time' => 'Activation Time',
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

		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('business_name',$this->business_name,true);
		$criteria->compare('business_address1',$this->business_address1,true);
		$criteria->compare('business_address2',$this->business_address2,true);
		$criteria->compare('business_city_id',$this->business_city_id);
		$criteria->compare('business_zipcode',$this->business_zipcode,true);
		$criteria->compare('business_phone_ext',$this->business_phone_ext,true);
		$criteria->compare('business_phone',$this->business_phone,true);
		$criteria->compare('business_email',$this->business_email,true);
		$criteria->compare('business_website',$this->business_website,true);
		$criteria->compare('business_description',$this->business_description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('business_allow_review',$this->business_allow_review,true);
		$criteria->compare('business_allow_rating',$this->business_allow_rating,true);
		$criteria->compare('business_keywords',$this->business_keywords,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('add_request_processing_status',$this->add_request_processing_status,true);
		$criteria->compare('add_request_processing_time',$this->add_request_processing_time,true);
		$criteria->compare('add_request_processed_by',$this->add_request_processed_by);
		$criteria->compare('add_request_rejection_reasom',$this->add_request_rejection_reasom,true);
		$criteria->compare('claim_status',$this->claim_status,true);
		$criteria->compare('claim_processing_time',$this->claim_processing_time,true);
		$criteria->compare('claimed_by',$this->claimed_by);
		$criteria->compare('claim_rejection_reasom',$this->claim_rejection_reasom,true);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('is_featured',$this->is_featured,true);
		$criteria->compare('is_closed',$this->is_closed,true);
		$criteria->compare('activation_code',$this->activation_code,true);
		$criteria->compare('activation_status',$this->activation_status,true);
		$criteria->compare('activation_time',$this->activation_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Business the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
