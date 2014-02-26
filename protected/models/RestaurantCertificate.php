<?php

/**
 * This is the model class for table "{{restaurant_certificate}}".
 *
 * The followings are the available columns in table '{{restaurant_certificate}}':
 * @property integer $certificate_id
 * @property string $certificate_number
 * @property string $purchase_amount
 * @property string $discount
 * @property string $purchase_date
 * @property integer $business_id
 * @property string $purchased_by_business_date
 * @property string $availability_status
 * @property string $redeemer_email
 * @property integer $redeemer_user_id
 * @property string $redeem_date
 *
 * The followings are the available model relations:
 * @property Business $business
 */
class RestaurantCertificate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{restaurant_certificate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_id, redeemer_user_id', 'numerical', 'integerOnly'=>true),
			array('certificate_number', 'length', 'max'=>255),
			array('purchase_amount, discount', 'length', 'max'=>13),
			array('availability_status', 'length', 'max'=>9),
			array('redeemer_email', 'length', 'max'=>64),
			array('purchase_date, purchased_by_business_date, redeem_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('certificate_id, certificate_number, purchase_amount, discount, purchase_date, business_id, purchased_by_business_date, availability_status, redeemer_email, redeemer_user_id, redeem_date', 'safe', 'on'=>'search'),
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
			'business' => array(self::BELONGS_TO, 'Business', 'business_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'certificate_id' => 'Certificate',
			'certificate_number' => 'Certificate Number',
			'purchase_amount' => 'Purchase Amount',
			'discount' => 'Discount',
			'purchase_date' => 'Purchase Date',
			'business_id' => 'Business',
			'purchased_by_business_date' => 'Purchased By Business Date',
			'availability_status' => 'Availability Status',
			'redeemer_email' => 'Redeemer Email',
			'redeemer_user_id' => 'Redeemer User',
			'redeem_date' => 'Redeem Date',
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

		$criteria->compare('certificate_id',$this->certificate_id);
		$criteria->compare('certificate_number',$this->certificate_number,true);
		$criteria->compare('purchase_amount',$this->purchase_amount,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('purchase_date',$this->purchase_date,true);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('purchased_by_business_date',$this->purchased_by_business_date,true);
		$criteria->compare('availability_status',$this->availability_status,true);
		$criteria->compare('redeemer_email',$this->redeemer_email,true);
		$criteria->compare('redeemer_user_id',$this->redeemer_user_id);
		$criteria->compare('redeem_date',$this->redeem_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RestaurantCertificate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
