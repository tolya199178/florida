<?php

/**
 * This is the model class for table "{{mail_template}}".
 *
 * The followings are the available columns in table '{{mail_template}}':
 * @property integer $template_id
 * @property string $template_name
 * @property string $msg
 * @property string $isreadonly
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property User $createdBy
 */
class MailTemplate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mail_template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_name, msg, modified_time, created_by, modified_by', 'required'),
			array('created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('template_name', 'length', 'max'=>128),
			array('isreadonly', 'length', 'max'=>1),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('template_id, template_name, msg, isreadonly, created_time, modified_time, created_by, modified_by', 'safe', 'on'=>'search'),
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
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'template_id' => 'Template',
			'template_name' => 'Template Name',
			'msg' => 'Msg',
			'isreadonly' => 'Isreadonly',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
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

		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('msg',$this->msg,true);
		$criteria->compare('isreadonly',$this->isreadonly,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MailTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
