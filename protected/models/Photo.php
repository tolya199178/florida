<?php

/**
 * This is the model class for table "{{photo}}".
 *
 * The followings are the available columns in table '{{photo}}':
 * @property integer $photo_id
 * @property string $photo_type
 * @property integer $entity_id
 * @property string $caption
 * @property string $title
 * @property string $path
 * @property string $thumbnail
 */
class Photo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{photo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id', 'required'),
			array('entity_id', 'numerical', 'integerOnly'=>true),
			array('photo_type', 'length', 'max'=>8),
			array('caption, title', 'length', 'max'=>255),
			array('path, thumbnail', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('photo_id, photo_type, entity_id, caption, title, path, thumbnail', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'photo_id' => 'Photo',
			'photo_type' => 'Photo Type',
			'entity_id' => 'Entity',
			'caption' => 'Caption',
			'title' => 'Title',
			'path' => 'Path',
			'thumbnail' => 'Thumbnail',
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

		$criteria->compare('photo_id',$this->photo_id);
		$criteria->compare('photo_type',$this->photo_type,true);
		$criteria->compare('entity_id',$this->entity_id);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('thumbnail',$this->thumbnail,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Photo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
