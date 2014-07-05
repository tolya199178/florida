<?php

/**
 * This is the model class for table "{{trip}}".
 *
 * The followings are the available columns in table '{{trip}}':
 * @property integer $trip_id
 * @property string $trip_name
 * @property string $description
 * @property integer $trip_status
 * @property integer $user_id
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property User $user
 * @property TripLeg[] $tripLegs
 */

 /**
 * Trip activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = Trip::model()
 * ...or
 * ...   $model = new Trip;
 * ...or
 * ...   $model = new Trip($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class Trip extends CActiveRecord
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
		return '{{trip}}';
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
			array('user_id, created_date', 'required'),
			array('trip_status, user_id', 'numerical', 'integerOnly'=>true),
			array('trip_name', 'length', 'max'=>150),
			array('description, modified_date', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('trip_id, trip_name, description, trip_status, user_id, created_date, modified_date', 'safe', 'on'=>'search'),
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
			'user'      => array(self::BELONGS_TO, 'User', 'user_id'),
			'tripLegs'      => array(self::HAS_MANY, 'TripLeg', 'trip_id'),
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
			'trip_id'      => 'Trip',
			'trip_name'      => 'Trip Name',
			'description'      => 'Description',
			'trip_status'      => 'Trip Status',
			'user_id'      => 'User',
			'created_date'      => 'Created Date',
			'modified_date'      => 'Modified Date',
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

		$criteria->compare('trip_id',$this->trip_id);
		$criteria->compare('trip_name',$this->trip_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('trip_status',$this->trip_status);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Trip the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
