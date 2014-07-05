<?php

/**
 * This is the model class for table "{{trip_leg}}".
 *
 * The followings are the available columns in table '{{trip_leg}}':
 * @property integer $tbl_trip_leg
 * @property integer $trip_id
 * @property integer $city_id
 * @property string $leg_start_date
 * @property string $leg_end_date
 * @property string $description
 *
 * The followings are the available model relations:
 * @property City $city
 * @property Trip $trip
 */

 /**
 * TripLeg activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = TripLeg::model()
 * ...or
 * ...   $model = new TripLeg;
 * ...or
 * ...   $model = new TripLeg($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class TripLeg extends CActiveRecord
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
		return '{{trip_leg}}';
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
			array('trip_id, city_id', 'required'),
			array('trip_id, city_id', 'numerical', 'integerOnly'=>true),
			array('leg_start_date, leg_end_date, description', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('tbl_trip_leg, trip_id, city_id, leg_start_date, leg_end_date, description', 'safe', 'on'=>'search'),
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
			'city'      => array(self::BELONGS_TO, 'City', 'city_id'),
			'trip'      => array(self::BELONGS_TO, 'Trip', 'trip_id'),
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
			'tbl_trip_leg'      => 'Tbl Trip Leg',
			'trip_id'      => 'Trip',
			'city_id'      => 'City',
			'leg_start_date'      => 'Leg Start Date',
			'leg_end_date'      => 'Leg End Date',
			'description'      => 'Description',
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

		$criteria->compare('tbl_trip_leg',$this->tbl_trip_leg);
		$criteria->compare('trip_id',$this->trip_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('leg_start_date',$this->leg_start_date,true);
		$criteria->compare('leg_end_date',$this->leg_end_date,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return TripLeg the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
