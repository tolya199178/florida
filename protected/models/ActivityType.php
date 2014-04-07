<?php

/**
 * This is the model class for table "{{activity_type}}".
 *
 * The followings are the available columns in table '{{activity_type}}':
 * @property integer $activity_type_id
 * @property string $keyword
 * @property integer $activity_id
 * @property string $language
 * @property string $related_words
 *
 * The followings are the available model relations:
 * @property Activity $activity
 */
class ActivityType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{activity_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword, activity_id', 'required'),
			array('activity_id', 'numerical', 'integerOnly'=>true),
			array('keyword', 'length', 'max'=>255),
			array('language', 'length', 'max'=>8),
			array('related_words', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('activity_type_id, keyword, activity_id, language, related_words', 'safe', 'on'=>'search'),
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
			'activity' => array(self::BELONGS_TO, 'Activity', 'activity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'activity_type_id' => 'Activity Type',
			'keyword' => 'Keyword',
			'activity_id' => 'Activity',
			'language' => 'Language',
			'related_words' => 'Related Words',
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

		$criteria->compare('activity_type_id',$this->activity_type_id);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('related_words',$this->related_words,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActivityType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
