<?php

/**
 * This is the model class for table "{{business_activity}}".
 *
 * The followings are the available columns in table '{{business_activity}}':
 * @property integer $business_activity_id
 * @property integer $business_id
 * @property integer $activity_id
 * @property integer $activity_type_id
 *
 * The followings are the available model relations:
 * @property ActivityType $activityType
 * @property Activity $activity
 * @property Business $business
 */

/**
 * BusinessActivity activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...The table is a 'barebones' table and will not normally have a seperate UI
 * ...associated with it, therefore the absence of attributes and rules. The
 * ...typical usage for user input will be 'embedding' with the business screens.
 * ...
 * ...Usage:
 * ...   $business_activity = BusinessActivity::model()
 * ...or
 * ...   $business_activity = new BusinessActivity;
 * ...or
 * ...   $business_activity = new BusinessActivity($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class BusinessActivity extends CActiveRecord
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
		return '{{business_activity}}';
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
			'activity'       => array(self::BELONGS_TO, 'Activity', 'activity_id'),
			'business'       => array(self::BELONGS_TO, 'Business', 'business_id'),
		    'activityType'   => array(self::BELONGS_TO, 'ActivityType', 'activity_type_id'),
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

		$criteria->compare('business_activity_id',$this->business_activity_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('activity_type_id',$this->activity_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 * @return BusinessActivity the static model class
	 *
	 * @access public
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
