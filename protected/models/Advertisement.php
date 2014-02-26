<?php

/**
 * This is the model class for table "{{advertisement}}".
 *
 * The followings are the available columns in table '{{advertisement}}':
 * @property integer $advertisement_id
 * @property string $advert_type
 * @property string $title
 * @property string $content
 * @property string $image
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $published
 * @property string $piblish_date
 * @property string $expiry_date
 * @property integer $user_id
 * @property double $maximum_ads_views
 * @property double $maximum_ads_clicks
 * @property double $ads_views
 * @property double $ads_clicks
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $createdBy
 * @property User $modifiedBy
 */
class Advertisement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advertisement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, modified_time, created_by, modified_by', 'required'),
			array('created_by, modified_by, user_id', 'numerical', 'integerOnly'=>true),
			array('maximum_ads_views, maximum_ads_clicks, ads_views, ads_clicks', 'numerical'),
			array('advert_type', 'length', 'max'=>6),
			array('title', 'length', 'max'=>255),
			array('published', 'length', 'max'=>1),
			array('image, created_time, piblish_date, expiry_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('advertisement_id, advert_type, title, content, image, created_time, modified_time, created_by, modified_by, published, piblish_date, expiry_date, user_id, maximum_ads_views, maximum_ads_clicks, ads_views, ads_clicks', 'safe', 'on'=>'search'),
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
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'advertisement_id' => 'Advertisement',
			'advert_type' => 'Advert Type',
			'title' => 'Title',
			'content' => 'Content',
			'image' => 'Image',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
			'published' => 'Published',
			'piblish_date' => 'Piblish Date',
			'expiry_date' => 'Expiry Date',
			'user_id' => 'User',
			'maximum_ads_views' => 'Maximum Ads Views',
			'maximum_ads_clicks' => 'Maximum Ads Clicks',
			'ads_views' => 'Ads Views',
			'ads_clicks' => 'Ads Clicks',
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

		$criteria->compare('advertisement_id',$this->advertisement_id);
		$criteria->compare('advert_type',$this->advert_type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('published',$this->published,true);
		$criteria->compare('piblish_date',$this->piblish_date,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('maximum_ads_views',$this->maximum_ads_views);
		$criteria->compare('maximum_ads_clicks',$this->maximum_ads_clicks);
		$criteria->compare('ads_views',$this->ads_views);
		$criteria->compare('ads_clicks',$this->ads_clicks);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertisement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
