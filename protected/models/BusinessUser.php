<?php

/**
 * This is the model class for table "{{business_user}}".
 *
 * The followings are the available columns in table '{{business_user}}':
 * @property integer $business_user_id
 * @property integer $business_id
 * @property integer $user_id
 * @property string $primary_user
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $user
 */
class BusinessUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{business_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_id, user_id', 'required'),
			array('business_id, user_id', 'numerical', 'integerOnly'=>true),
			array('primary_user', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('business_user_id, business_id, user_id, primary_user', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'business_user_id' => 'Business User',
			'business_id' => 'Business',
			'user_id' => 'User',
			'primary_user' => 'Primary User',
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

		$criteria->compare('business_user_id',$this->business_user_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('primary_user',$this->primary_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BusinessUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
