<?php

/**
 * This is the model class for table "{{twilio_business_verification}}".
 *
 * The followings are the available columns in table '{{twilio_business_verification}}':
 * @property integer $twilio_business_verification_id
 * @property string $phone
 * @property string $code
 * @property string $call_sid
 * @property integer $business_id
 * @property integer $user_id
 * @property string $status
 * @property string $call_status
 * @property integer $attempts
 * @property string $created_time
 * @property string $modified_time
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $user
 */

 /**
 * TwilioBusinessVerification activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = TwilioBusinessVerification::model()
 * ...or
 * ...   $model = new TwilioBusinessVerification;
 * ...or
 * ...   $model = new TwilioBusinessVerification($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class TwilioBusinessVerification extends CActiveRecord
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
		return '{{twilio_business_verification}}';
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
			array('phone, code, call_sid, business_id', 'required'),
			array('business_id, user_id, attempts', 'numerical', 'integerOnly'=>true),
			array('phone, code', 'length', 'max'=>50),
			array('call_sid, status, call_status', 'length', 'max'=>255),
			array('created_time, modified_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('twilio_business_verification_id, phone, code, call_sid, business_id, user_id, status, call_status, attempts, created_time, modified_time', 'safe', 'on'=>'search'),
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
			'business'      => array(self::BELONGS_TO, 'Business', 'business_id'),
			'user'      => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'twilio_business_verification_id'      => 'Twilio Business Verification',
			'phone'      => 'Phone',
			'code'      => 'Code',
			'call_sid'      => 'Call Sid',
			'business_id'      => 'Business',
			'user_id'      => 'User',
			'status'      => 'Status',
			'call_status'      => 'Call Status',
			'attempts'      => 'Attempts',
			'created_time'      => 'Created Time',
			'modified_time'      => 'Modified Time',
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

		$criteria->compare('twilio_business_verification_id',$this->twilio_business_verification_id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('call_sid',$this->call_sid,true);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('call_status',$this->call_status,true);
		$criteria->compare('attempts',$this->attempts);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return TwilioBusinessVerification the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
