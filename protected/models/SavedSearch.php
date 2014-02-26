<?php

/**
 * This is the model class for table "{{saved_search}}".
 *
 * The followings are the available columns in table '{{saved_search}}':
 * @property integer $search_id
 * @property integer $user_id
 * @property string $search_name
 * @property string $created_time
 * @property string $search_details
 *
 * The followings are the available model relations:
 * @property User $user
 */
class SavedSearch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{saved_search}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, created_time, search_details', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('search_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('search_id, user_id, search_name, created_time, search_details', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'search_id' => 'Search',
			'user_id' => 'User',
			'search_name' => 'Search Name',
			'created_time' => 'Created Time',
			'search_details' => 'Search Details',
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

		$criteria->compare('search_id',$this->search_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('search_name',$this->search_name,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('search_details',$this->search_details,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SavedSearch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
